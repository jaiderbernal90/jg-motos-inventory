<?php
namespace App\Http\Controllers\contacts;

use App\Exports\CustomersExport;
use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\contacts\Customer;
use App\Models\accounting\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use App\helpers\ResponseHelper;
use App\Models\setting\TypePerson;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller{
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

        $data = Customer::select('customers.*', 'types_of_documents.name as type_document', 'types_of_persons.name as type_person')
        ->leftjoin('types_of_documents', 'customers.id_type_document', '=', 'types_of_documents.id')
        ->leftjoin('types_of_persons', 'customers.id_type_person', '=', 'types_of_persons.id')
        ->where(function ($query) use ($term) {
            $query->where('customers.full_name', 'like', "%$term%");
            $query->orWhere('customers.document', 'like', "%$term%");
            $query->orWhere('customers.cellphone', 'like', "%$term%");
            $query->orWhere('customers.email', 'like', "%$term%");
            $query->orWhere('customers.address', 'like', "%$term%");
        })->orderBy('customers.id', 'DESC')->paginate($limit);

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
                'id_type_person' => 'required',
                'full_name' => 'required|min:5',
                'id_type_document' => 'required',
                'document' => 'required|unique:customers',
                'cellphone' => 'required|numeric',
                'email' => 'required|email|unique:customers',
                'address' => 'required'
            ]);
            $data = Customer::create($request->all());

            $audit = new AuditHelper;
            $audit->auditCustomer($data->id, 1);
            
            return ResponseHelper::CreateOrUpdate($data, 'Cliente creado correctamente');
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'El cliente no pudo ser creado');
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
        $data = Customer::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un cliente con el id '.  $id);
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
        $data = Customer::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un cliente con el id ' .  $id);
        }
        try {
            $data->update([
                'full_name' => $request->input('full_name'),
                'cellphone' => $request->input('cellphone'),
                'email' => $request->input('email'),
                'address' => $request->input('address')
            ]);

            $audit = new AuditHelper;
            $audit->auditCustomer($data->id, 2);

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
        $data = Customer::find($id);

        if (!$data) {
            return ResponseHelper::NoExits('No existe un cliente con el id ' .  $id);
        }

        $saleCustomer = Sale::where('id_customer', $id)->first();
        if ($saleCustomer){
            return ResponseHelper::NoExits('El cliente no se puede eliminar porque ya existe una venta a su nombre');
        }

        $audit = new AuditHelper;
        $audit->auditCustomer($data->id, 3);

        $data->delete();

        return ResponseHelper::Delete('Cliente eliminado correctamente');
    }

    /**
     * GET TYPES PERSONS ALL
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTypePersons()
    {
        $typesPersons = TypePerson::all();

        return ResponseHelper::Get($typesPersons);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getForDocuments(Request $request)
    {
        $document = @$request->document;
        $type_document =@ $request->type_document;
        
        
        $data = Customer::select('full_name','id_type_document','document','cellphone','email','id as id_customer')->where(['document' => $document,'id_type_document' => $type_document])->first();
        
        if($data) $data['client_exists'] = true;

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
        return Excel::download(new CustomersExport, 'Listado-clientes.xlsx');
    }
}