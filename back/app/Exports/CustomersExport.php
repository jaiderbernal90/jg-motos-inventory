<?php

namespace App\Exports;

use App\Models\contacts\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomersExport implements FromView
{
    public function view(): View
    {
        $data = Customer::select('customers.*', 'types_of_persons.name as typePerson', 'types_of_documents.name as typeDocument')
        ->leftjoin('types_of_persons', 'customers.id_type_person', '=', 'types_of_persons.id')
        ->leftjoin('types_of_documents', 'customers.id_type_document', '=', 'types_of_documents.id')
        ->get();

        return view('exportsExcel.customers', ['data' => $data]);
    }
}
