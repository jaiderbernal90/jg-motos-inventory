<?php

namespace App\Exports;

use App\Models\inventory\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        $data = Product::select('products.*', 'brands.name as brand', 'sections.name as section', 'columns.name as column', 'rows.name as row')
        ->leftjoin('brands', 'products.id_brand', '=', 'brands.id')
        ->leftjoin('sections', 'products.id_section', '=', 'sections.id')
        ->leftjoin('columns', 'products.id_column', '=', 'columns.id')
        ->leftjoin('rows', 'products.id_row', '=', 'rows.id')
        ->get();

        return view('exportsExcel.products', ['data' => $data]);
    }
}
