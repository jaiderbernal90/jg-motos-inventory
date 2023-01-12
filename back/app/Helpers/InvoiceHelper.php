<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class InvoiceHelper
{
    public static function download($sale, $detailSail, $local)
    {
        $data['logoLocal'] = $local->logo;
        $data['nameLocal'] = $local->name;
        $data['nitLocal'] = $local->nit;
        $data['cellphoneLocal'] = $local->cellphone;
        $data['departmentLocal'] = $local->department;
        $data['cityLocal'] = $local->city;
        $data['directionLocal'] = $local->direction;
        $data['referenceSale'] = $sale->reference;
        $data['date'] = $sale->created_at->format('d M Y h:m');
        $data['seller'] = Auth::user()->full_name;
        $data['detailSail'] = $detailSail;
        $data['subtotal'] = $sale->subtotal;
        $data['tax'] = $sale->tax;
        $data['total'] = $sale->total;
        $data['paymentMethod'] = $sale->paymentMethod;

        $pdf = PDF::loadView('exportsPdf.invoice', [
            'data' => $data
        ]);
        $pdf->setPaper('b7', 'portrait');
        
        return $pdf->download("Factura #$sale->reference.pdf");
    }
}
