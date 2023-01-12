<?php
namespace App\Http\Controllers\inventory;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\inventory\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;

class SubcategoryController extends Controller{
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
        $id_category = $request->get('category');
       
        $sql = [];

        if (isset($id_category)) {
            $sql[] = ['sub_categories.id_category', '=', $id_category];
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Subcategory::where($sql)->select('sub_categories.*','categories.name as category')
        ->leftjoin('categories', 'sub_categories.id_category', '=', 'categories.id')
        ->where(function ($query) use ($term) {
            $query->where('sub_categories.code', 'like', "%$term%");
            $query->orWhere('sub_categories.name', 'like', "%$term%");
            $query->orWhere('categories.name', 'like', "%$term%");
        })  
        ->orderBy('sub_categories.id', 'DESC')->paginate($limit);


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
            $request->validate([
                'code' => 'required|unique:sub_categories',
                'name' => 'required',
                'id_category' => 'required'
            ]);
            $data = Subcategory::create($request->all());

            $audit = new AuditHelper;
            $audit->auditSubCategory($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Subcategoria creada correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La subcategoria no pudo ser creada');
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
        $data = Subcategory::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una subcategoria con el id '.  $id);
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
        $data = Subcategory::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una subcategoria con el id ' .  $id);
        }
        try {
            $data->update([
                'name' => $request->input('name'),
                'id_category' => $request->input('id_category')
            ]);

            $audit = new AuditHelper;
            $audit->auditSubCategory($data->id, 2);

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
        $data = Subcategory::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una subcategoria con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditSubCategory($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Subcategoria eliminada correctamente');
    }

    /**
     * get id latest
     */
    public function getCount()
    {
        $data = Subcategory::latest('id')->first();

        return ResponseHelper::Get($data);
    }
}