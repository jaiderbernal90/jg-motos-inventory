<?php

namespace App\Exports;

use App\Models\inventory\Category;
use App\Models\inventory\Subcategory;
use App\Models\setting\Role;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubcategoriesExport implements FromView
{
    public function view(): View
    {
        $data = Subcategory::select('sub_categories.*', 'categories.name as nameCategory')
        ->leftjoin('categories', 'sub_categories.id_category', '=', 'categories.id')
        ->get();

        return view('exportsExcel.subcategories', ['data' => $data]);
    }
}
