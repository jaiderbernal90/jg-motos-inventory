<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\accounting\Bail;
use App\Models\accounting\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function closingDayling(Request $request)
    {
        $date = $request->date;

        $data['sales']['numSales'] = Sale::whereDate('created_at', $date)->count();
        $data['sales']['valueDay'] = Sale::whereDate('created_at', $date)->sum('total');
        $data['sales']['cash'] = Sale::where('id_payment_method', 1)->whereDate('created_at', $date)->sum('total');
        $data['sales']['bancolombia'] = Sale::where('id_payment_method', 4)->whereDate('created_at', $date)->sum('total');
        $data['sales']['nequi'] = Sale::where('id_payment_method', 2)->whereDate('created_at', $date)->sum('total');
        $data['sales']['daviplata'] = Sale::where('id_payment_method', 3)->whereDate('created_at', $date)->sum('total');

        $data['bails']['numBails'] = Bail::whereDate('created_at', $date)->count();
        $data['bails']['bailsDay'] = Bail::whereDate('created_at', $date)->sum('price');
        $data['bails']['cash'] = Bail::where('id_payment_method', 1)->whereDate('created_at', $date)->sum('price');
        $data['bails']['bancolombia'] = Bail::where('id_payment_method', 4)->whereDate('created_at', $date)->sum('price');
        $data['bails']['nequi'] = Bail::where('id_payment_method', 2)->whereDate('created_at', $date)->sum('price');
        $data['bails']['daviplata'] = Bail::where('id_payment_method', 3)->whereDate('created_at', $date)->sum('price');

        return $data;
    }
}
