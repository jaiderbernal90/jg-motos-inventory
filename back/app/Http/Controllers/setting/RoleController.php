<?php
namespace App\Http\Controllers\setting;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\setting\Role;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use App\Models\Module;
use App\Models\ModuleForRole;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller{
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

        $data = Role::whereNot('id', 1)
        ->select(['id','name','description'])->where(function ($query) use ($term) {
            $query->where('name', 'like', "%$term%");
            $query->orWhere('description', 'like', "%$term%");
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
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'modules' => 'required'
        ]);
        
        $data = Role::create($request->all());
        $data->modules()->sync(@$request->modules);

        $audit = new AuditHelper;
        $audit->auditRole($data->id, 1);
        if($audit){
            return ResponseHelper::CreateOrUpdate($data, 'Rol creado correctamente');
        }else{
            return $audit;
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
        $role = Role::find($id);

        $modules = Module::select('modules.id', 'modules.name', 'modules_for_roles.has_admin', 'modules_for_roles.selected')
        ->leftJoin('modules_for_roles', function($join) use ($id)
        {
            $join->on('modules.id', '=', 'modules_for_roles.module_id');
            $join->on('role_id', '=', DB::raw("$id"));
        })
        ->get();

        $data['role'] = $role;
        $data['modules'] = $modules;

        if (!$data) {
            return ResponseHelper::NoExits('No existe un rol con el id '.  $id);
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
        $data = Role::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un rol con el id ' .  $id);
        }
        try {
            $data->update([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
            
            if($data->modules) $data->modules()->detach();
            $data->modules()->attach(@$request->modules);
        
            $audit = new AuditHelper;
            $audit->auditRole($data->id, 2);

            return  ResponseHelper::CreateOrUpdate($data, 'Información actualizada correctamente');
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
        $data = Role::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un rol con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditRole($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Rol eliminado correctamente');
    }

    /**
     * Display a listing of the modules.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getModules()
    {
        $data = Module::all();

        return ResponseHelper::Get($data);
    }
}