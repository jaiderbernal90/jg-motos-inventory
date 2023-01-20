<?php

namespace App\Http\Controllers\reports;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\accounting\Bail;
use App\Models\accounting\Expense;
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
        $type = $request->type;

        $sale = $this->getSale($type, $date); 
        $bail = $this->getBail($type, $date);
        $expense = $this->getExpense($type, $date); 

        $data['sales']['numSales'] = $sale->count();
        $data['sales']['valueDay'] = $sale->sum('total');
        $data['sales']['cash'] = $sale->where('id_payment_method', 1)->sum('total');
        $data['sales']['bancolombia'] = $sale->where('id_payment_method', 4)->sum('total');
        $data['sales']['nequi'] = $sale->where('id_payment_method', 2)->sum('total');
        $data['sales']['daviplata'] = $sale->where('id_payment_method', 3)->sum('total');
        

        $data['bails']['numBails'] = $bail->count();
        $data['bails']['bailsDay'] = $bail->sum('price');
        $data['bails']['cash'] = $bail->where('id_payment_method', 1)->sum('price');
        $data['bails']['bancolombia'] = $bail->where('id_payment_method', 4)->sum('price');
        $data['bails']['nequi'] = $bail->where('id_payment_method', 2)->sum('price');
        $data['bails']['daviplata'] = $bail->where('id_payment_method', 3)->sum('price');


        $data['expenses']['numExpenses'] = $expense->count();
        $data['expenses']['valueDay'] = $expense->sum('value');

        return ResponseHelper::Get($data);
    }

    private function getSale(String $type, $date){
        if($type == 'month' ){
            $rangeDates = $this->getLastDayMonth($date);
            return Sale::whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return Sale::whereDate('created_at', $date);
    }

    private function getBail(String $type, $date){
        if($type == 'month'){
            $rangeDates = $this->getLastDayMonth($date);
            return Bail::whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return Bail::whereDate('created_at', $date);
    }

    private function getExpense(String $type, $date){
        if($type == 'month'){
            $rangeDates = $this->getLastDayMonth($date);
            return Expense::whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return Expense::whereDate('created_at', $date);
    }

    private function getLastDayMonth($date) {
        $parseDate = Carbon::parse($date);
        $arr['month'] = $parseDate->format('m');
        $arr['year'] = $parseDate->format('Y');
        return $arr;
    }
}