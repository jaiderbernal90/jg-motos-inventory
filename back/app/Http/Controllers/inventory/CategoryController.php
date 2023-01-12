<?php
namespace App\Http\Controllers\inventory;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\inventory\Category;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;

class CategoryController extends Controller{
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

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Category::where(function ($query) use ($term) {
            $query->where('code', 'like', "%$term%");
            $query->orWhere('name', 'like', "%$term%");
        })->orderBy('id', 'DESC')->paginate($limit);

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
                'code' => 'required|unique:categories',
                'name' => 'required'
            ]);
            $data = Category::create($request->all());
            
            $audit = new AuditHelper;
            $audit->auditCategory($data->id, 1);

            return ResponseHelper::CreateOrUpdate($data, 'Categoria creada correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La categoria no pudo ser creada');
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
        $data = Category::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una categoria con el id '.  $id);
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
        $data = Category::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una categoria con el id ' .  $id);
        }
        try {
            $data->update([
                'name' => $request->input('name')
            ]);

            $audit = new AuditHelper;
            $audit->auditCategory($data->id, 2);

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
        $data = Category::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe una categoria con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditCategory($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Categoria eliminada correctamente');
    }

     /**
     * get id latest
     */
    public function getCount()
    {
        $data = Category::latest('id')->first();

        return ResponseHelper::Get($data);
    }
}