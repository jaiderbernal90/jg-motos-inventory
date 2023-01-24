<?php

namespace App\Exports;

use App\Models\accounting\Bail;
use App\Models\accounting\Sale;
use App\Models\accounting\SalesDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    public function view(): View
    {
        $sales = Sale::select('sales.*', 'customers.document as documentClient', 'customers.full_name as nameClient', 'payment_methods.name as paymentMethod')
        ->leftjoin('customers', 'sales.id_customer', '=', 'customers.id')
        ->leftjoin('payment_methods', 'sales.id_payment_method', '=', 'payment_methods.id')
        ->get();

        foreach ($sales as $sale){
            $products = SalesDetail::select('sales_detail.amount', 'sales_detail.price', 'products.reference', 'products.name')
            ->leftjoin('products', 'sales_detail.product_id', '=', 'products.id')
            ->where('sales_detail.sale_id', $sale->id)
            ->get();
            $sale['products'] = $products;
        }

        foreach ($sales as $sale){
            $bails = Bail::select('created_at as dateBail', 'price')->where('id_sale', $sale->id)->get();
            $sale['bails'] = $bails;
        }

        $data = $sales;

        return view('exportsExcel.sales', ['data' => $data]);
    }
}
