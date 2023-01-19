<?php
namespace App\Http\Controllers\inventory;

use App\Exports\ProductsExport;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\inventory\Product;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use App\Models\accounting\SalesDetail;

class ProductController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 10;
        $term = $request->get('term');
        $status = $request->get('status');
        $category = $request->get('category');
        $subcategory = $request->get('subcategory');
        $brand = $request->get('brand');

        $sql = [];

        if (isset($status)) {
            $sql[] = ['products.status', '=', $status];
        }
        if (isset($brand)) {
            $sql[] = ['products.id_brand', '=', $brand];
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Product::where($sql)->select('products.*', 'brands.name as brand')
        ->leftjoin('brands', 'products.id_brand', '=', 'brands.id')
        ->where(function ($query) use ($term) {
            $query->where('products.name', 'like', "%$term%");
            $query->orWhere('products.reference', 'like', "%$term%");
            $query->orWhere('products.price', 'like', "%$term%");
            $query->orWhere('brands.name', 'like', "%$term%");
        })
        ->with(['categories' => function ($query) { 
            $query->select('categories.id as category_id','categories.name as name_category','sub_categories.name as name_subcategory','sub_categories.id as sub_category_id');
            $query->leftjoin('sub_categories', 'sub_categories.id', '=', 'products_for_category.sub_category_id');
        }])
        ->where(function ($query) use ($category, $subcategory) {
            if(isset($category) || isset($subcategory)){
                $query->whereHas('categories', function ($query) use ($category, $subcategory) { 
                    if(isset($category) && !isset($subcategory)) $query->where ('products_for_category.category_id', $category);
                    if(isset($subcategory)) $query->where ('products_for_category.sub_category_id', $subcategory);
                });
            }
        })
        ->orderBy('products.id', 'DESC')->paginate($limit);

        return ResponseHelper::Get($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $price = @$request->input('price');
            $discount = @$request->input('discount');
            $price_total = $price - ($price * $discount / 100) ;

            $data = Product::create([
                'code' => @$request->input('code'),
                'name' => @$request->input('name'),
                'description' => @$request->input('description'),
                'applications' => @$request->input('applications'),
                'reference' => @$request->input('reference'),
                'id_brand' => @$request->input('id_brand'),
                'images'=> @$request->input('images'),
                'stock'=> @$request->input('stock'),
                'stockMin'=> @$request->input('stockMin'),
                'status'=> @$request->input('status'),
                'cost'=> @$request->input('cost'),
                'price'=> $price,
                'tax'=> @$request->input('tax'),
                'discount'=> @$request->input('discount'),
                'price_total'=> $price_total,
                'original'=> @$request->input('original'),
                'barcode'=> @$request->input('barcode'),
                'id_section'=> @$request->input('id_section'),
                'id_column'=> @$request->input('id_column'),
                'id_row'=> @$request->input('id_row')
            ]);

            $data->categories()->sync(@$request->categories);

            $audit = new AuditHelper;
            $audit->auditProduct($data->id, 1);

            return ResponseHelper::CreateOrUpdate($data, 'Producto creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El producto no pudo ser creado');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::select('products.*','brands.name as brand', 'sections.name as section', 'rows.name as row', 'columns.name as column')
        ->leftjoin('brands', 'products.id_brand', '=', 'brands.id')
        ->leftjoin('sections', 'products.id_section', '=', 'sections.id')
        ->leftjoin('rows', 'products.id_row', '=', 'rows.id')
        ->leftjoin('columns', 'products.id_column', '=', 'columns.id')
        ->with(['categories' => function ($query) { 
            $query->select('categories.id as category_id','categories.name as name_category','sub_categories.name as name_subcategory','sub_categories.id as sub_category_id');
            $query->leftjoin('sub_categories', 'sub_categories.id', '=', 'products_for_category.sub_category_id');
        }])
        ->withSum('sales_detail','amount')
        ->find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un producto con el id '.  $id);
        }
        return ResponseHelper::Get($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Product::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un producto con el id ' .  $id);
        }
        try {
            $price = @$request->input('price');
            $discount = @$request->input('discount');
            $price_total = $price - ($price * $discount / 100);

            $data->update([
                'name' => @$request->input('name'),
                'description' => @$request->input('description'),
                'applications' => @$request->input('applications'),
                'reference' => @$request->input('reference'),
                'id_brand' => @$request->input('id_brand'),
                'images'=> @$request->input('images'),
                'stock'=> @$request->input('stock'),
                'stockMin'=> @$request->input('stockMin'),
                'status'=> @$request->input('status'),
                'cost'=> @$request->input('cost'),
                'price'=> $price,
                'tax'=> @$request->input('tax'),
                'discount'=> @$request->input('discount'),
                'original'=> @$request->input('original'),
                'price_total'=> $price_total,
                'barcode'=> @$request->input('barcode'),
                'id_section'=> @$request->input('id_section'),
                'id_column'=> @$request->input('id_column'),
                'id_row'=> @$request->input('id_row')
            ]);

            if($data->categories) $data->categories()->detach();
            $data->categories()->attach(@$request->input('categories'));

            $audit = new AuditHelper;
            $audit->auditProduct($data->id, 2);

            return  ResponseHelper::CreateOrUpdate($data, 'Información actualizada correctamente',);
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La información no pudo ser actualizada');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un producto con el id ' .  $id);
        }

        $saleProduct = SalesDetail::where('product_id', $id)->first();
        if ($saleProduct){
            return ResponseHelper::NoExits('El producto no se puede eliminar porque ya esta registrado en una venta');
        }

        $audit = new AuditHelper;
        $audit->auditProduct($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Producto eliminado correctamente');
    }

    /**
     * get id latest
     */
    public function getCount()
    {
        $data = Product::latest('id')->first();

        return ResponseHelper::Get($data);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getForReference($reference)
    {
        $data = Product::select('id','name','stock','price_total as price')
                ->where('reference',$reference)->first();
        
        if (!$data) {
            return ResponseHelper::NoExits('No existe un producto con referencia '. $reference);
        }

        return ResponseHelper::Get($data);
    }

     /**
     * Export resource data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'Listado-product.xlsx');
    }

    public function importExcel(Request $request)
    {

        $this->validate($request,[
            'myFile' => 'required',
        ]);

        $file = $request->file('myFile')->store('temp'); 
        $path= storage_path('app').'/'.$file;  

        if ($file){
            $helperImport = new ProductsImport;
            Excel::import($helperImport, $path);

            return ResponseHelper::Get([ 
                'rowsSaved'=>$helperImport->getRowCount(), 
                'productsNoSaved' => $helperImport->getProductsNoSaved()
            ]);
        }

        return ResponseHelper::NoExits('Archivo no valido' );

    }
}