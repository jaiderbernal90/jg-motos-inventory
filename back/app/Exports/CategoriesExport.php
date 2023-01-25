<?php

namespace App\Exports;

use App\Models\inventory\Category;
use App\Models\setting\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoriesExport implements FromView
{
    public function view(): View
    {
        $data = Category::all();

        return view('exportsExcel.categories', ['data' => $data]);
    }
}
