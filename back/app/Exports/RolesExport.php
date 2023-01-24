<?php

namespace App\Exports;

use App\Models\setting\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RolesExport implements FromView
{
    public function view(): View
    {
        $data = Role::all();

        return view('exportsExcel.roles', ['data' => $data]);
    }
}
