<?php

namespace App\Exports;

use App\Models\inventory\Brand;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BrandsExport implements FromView
{
    public function view(): View
    {
        $data = Brand::all();

        return view('exportsExcel.brands', ['data' => $data]);
    }
}
