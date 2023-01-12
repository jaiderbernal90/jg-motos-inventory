<?php
namespace App\Http\Controllers\setting;

use App\Exports\UsersExport;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\setting\User;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use App\Models\setting\Role;
use App\Models\setting\TypeDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller{
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
        $role = $request->get('role');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $sql = [];

        if (isset($status)) {
            $sql[] = ['users.status', '=', $status];
        }

        if (isset($role)) {
            $sql[] = ['users.id_role', '=', $role];
        }


        $data = User::whereNot('users.id', 1)->where($sql)->select('users.*', 'types_of_documents.name as type_document','roles.name as role')
        ->leftjoin('types_of_documents', 'users.id_type_document', '=', 'types_of_documents.id')
        ->leftjoin('roles', 'users.id_role', '=', 'roles.id')
        ->where(function ($query) use ($term) {
            $query->where('full_name', 'like', "%$term%");
            $query->orWhere('document', 'like', "%$term%");
            $query->orWhere('email', 'like', "%$term%");
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
        
        $data = $request->validate([
            'full_name' => 'required',
            'id_type_document' => 'required|exists:App\Models\setting\TypeDocument,id',
            'document' => 'required',
            'status' => 'required|boolean',
            'date_birth' => '',
            'phone' => '',
            'avatar' => 'image|max:1000',
            'email' => 'required|email',
            'id_role' => 'required|exists:App\Models\setting\Role,id',
            'password' => ''
        ]);

        if(User::where('document', $request->document)->exists()){
            return ResponseHelper::NoExits('El documento ingresado ya existe');
        }
        if(User::where('email', $request->email)->exists()){
            return ResponseHelper::NoExits('El correo ingresado ya existe');
        }
        try {
            $request['password'] = Hash::make($request['document']);
            $request['date_birth'] = Carbon::parse($request['date_birth'])->format('Y-m-d');

            $data = User::create($request->all());

            $audit = new AuditHelper;
            $audit->auditUser($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Usuario creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El usuario no pudo ser creado');
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
        $data = User::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un usuario con el id '.  $id);
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
        $data = User::find($id);
        
        if (!$data) {
            return ResponseHelper::NoExits('No existe un usuario con el id ' .  $id);
        }
        try {
            $data->update([
                'full_name' => $request->input('full_name'),
                'status' => $request->input('status'),
                'avatar' => $request->input('avatar'),
                'date_birth' => Carbon::parse(@$request['date_birth'])->format('Y-m-d'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'id_role' => $request->input('id_role'),
            ]);

            $audit = new AuditHelper;
            $audit->auditUser($data->id, 2);

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
        $data = User::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un usuario con el id ' .  $id);
        }

        $audit = new AuditHelper;
        $audit->auditUser($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Usuario eliminado correctamente');
    }

     /**
     * Change password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            User::where('id', $request->id)->update(['password' => Hash::make($request->password)]);
            return ResponseHelper::CreateOrUpdate($data, 'Contraseña actualizada correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El usuario no pudo ser creado');
        }
    }

     /**
     * validate password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validatePassword(Request $request)
    {
        $data = $request->validate([
            'password' => 'required',
        ]);

        try {

            $user = User::find($request->id);

            if( !Hash::check($request->password, $user->password) ) return ResponseHelper::Message('La contraseña actual no coindice');
            
            return ResponseHelper::Get($user);
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El usuario no pudo ser creado');
        }
    }

    /**
     * GET TYPES DOCUMENTS ALL
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTypeDocuments()
    {
        $typesDocuments = TypeDocument::all();

        return ResponseHelper::Get($typesDocuments);
    }

    /**
     * Export resource data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'Listado-usuarios.xlsx');
    }
}