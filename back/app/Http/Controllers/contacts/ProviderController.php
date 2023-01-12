<?php
namespace App\Http\Controllers\contacts;

use App\Exports\ProvidersExport;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\contacts\Provider;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use Maatwebsite\Excel\Facades\Excel;

class ProviderController extends Controller{
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

        $data = Provider::where(function ($query) use ($term) {
            $query->where('nit', 'like', "%$term%");
            $query->where('full_name', 'like', "%$term%");
            $query->where('landline', 'like', "%$term%");
            $query->where('cellphone', 'like', "%$term%");
            $query->where('email', 'like', "%$term%");
            $query->where('department', 'like', "%$term%");
            $query->where('city', 'like', "%$term%");
            $query->where('address', 'like', "%$term%");
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
                'nit' => 'required|unique:providers',
                'full_name' => 'required|min:5',
                'landline' => 'required',
                'cellphone' => 'required|numeric',
                'email' => 'required|unique:providers',
                'department' => 'required',
                'city' => 'required',
                'address' => 'required'
            ]);
            $data = Provider::create($request->all());

            $audit = new AuditHelper;
            $audit->auditProvider($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Proveedor creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El proveedor no pudo ser creado');
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
        $data = Provider::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un proveedor con el id '.  $id);
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
        $data = Provider::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un proveedor con el id ' .  $id);
        }
        try {
            $data->update([
                'nit' => $request->input('nit'),
                'full_name' => $request->input('full_name'),
                'landline' => $request->input('landline'),
                'cellphone' => $request->input('cellphone'),
                'department' => $request->input('department'),
                'email' => $request->input('email'),
                'city' => $request->input('city'),
                'address' => $request->input('address')
            ]);

            $audit = new AuditHelper;
            $audit->auditProvider($data->id, 2);

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
        $data = Provider::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un proveedor con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditProvider($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Proveedor eliminado correctamente');
    }

    /**
     * Export resource data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        return Excel::download(new ProvidersExport, 'Listado-proveedores.xlsx');
    }
}