<?php

namespace App\Exports;

use App\Models\contacts\Provider;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProvidersExport implements FromView
{
    public function view(): View
    {
        $data = Provider::all();

        return view('exportsExcel.providers', ['data' => $data]);
    }
}
