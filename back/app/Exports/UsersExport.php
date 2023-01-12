<?php

namespace App\Exports;

use App\Models\setting\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    public function view(): View
    {
        $data = User::select('users.*', 'roles.name as role', 'types_of_documents.name as typeDocument')
        ->whereNot('users.id', 1)
        ->leftjoin('roles', 'users.id_role', '=', 'roles.id')
        ->leftjoin('types_of_documents', 'users.id_type_document', '=', 'types_of_documents.id')
        ->get();

        return view('exportsExcel.users', ['data' => $data]);
    }
}
