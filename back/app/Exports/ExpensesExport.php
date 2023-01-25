<?php

namespace App\Exports;

use App\Models\accounting\Expense;
use App\Models\setting\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExpensesExport implements FromView
{
    public function view(): View
    {
        $data = Expense::all();

        return view('exportsExcel.expenses', ['data' => $data]);
    }
}
