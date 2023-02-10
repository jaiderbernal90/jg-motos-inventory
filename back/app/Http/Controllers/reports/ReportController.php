<?php

namespace App\Http\Controllers\reports;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\accounting\Bail;
use App\Models\accounting\BailOrder;
use App\Models\accounting\Expense;
use App\Models\accounting\Order;
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

        $data['sales']['numSales'] = $this->getSale($type, $date)->count();
        $data['sales']['valueDay'] = $this->getSale($type, $date)->where(['status'=> 1, 'total_bails' => null])->sum('total');
        $data['sales']['cash'] = $this->getSale($type, $date)->where(['id_payment_method' => 1, 'status'=> 1, 'total_bails' => null])->sum('total');
        $data['sales']['bancolombia'] = $this->getSale($type, $date)->where(['id_payment_method' => 4, 'status'=> 1, 'total_bails' => null])->sum('total');
        $data['sales']['nequi'] = $this->getSale($type, $date)->where(['id_payment_method' => 2, 'status'=> 1, 'total_bails' => null])->sum('total');
        $data['sales']['daviplata'] = $this->getSale($type, $date)->where(['id_payment_method' => 3, 'status'=> 1, 'total_bails' => null])->sum('total');
        

        $data['bails']['numBails'] = $this->getBail($type, $date)->count();
        $data['bails']['bailsDay'] = $this->getBail($type, $date)->sum('price');
        $data['bails']['cash'] = $this->getBail($type, $date)->where('id_payment_method', 1)->sum('price');
        $data['bails']['bancolombia'] = $this->getBail($type, $date)->where('id_payment_method', 4)->sum('price');
        $data['bails']['nequi'] = $this->getBail($type, $date)->where('id_payment_method', 2)->sum('price');
        $data['bails']['daviplata'] = $this->getBail($type, $date)->where('id_payment_method', 3)->sum('price');

        $data['invoices']['numInvoices'] = $this->getInvoice($type, $date)->count();
        $data['invoices']['payDay'] = $this->getInvoice($type, $date)->where(['payment_status'=> 1, 'total_bails' => null])->sum('total');
        $data['invoices']['cash'] = $this->getInvoice($type, $date)->where(['id_payment_method' => 1, 'payment_status'=> 1, 'total_bails' => null])->sum('total');
        $data['invoices']['bancolombia'] = $this->getInvoice($type, $date)->where(['id_payment_method' => 4, 'payment_status'=> 1, 'total_bails' => null])->sum('total');
        $data['invoices']['nequi'] = $this->getInvoice($type, $date)->where(['id_payment_method' => 2, 'payment_status'=> 1, 'total_bails' => null])->sum('total');
        $data['invoices']['daviplata'] = $this->getInvoice($type, $date)->where(['id_payment_method' => 3, 'payment_status'=> 1, 'total_bails' => null])->sum('total');

        $data['bailsInvoices']['numBails'] = $this->getBailInvoice($type, $date)->count();
        $data['bailsInvoices']['bailsDay'] = $this->getBailInvoice($type, $date)->sum('price');
        $data['bailsInvoices']['cash'] = $this->getBailInvoice($type, $date)->where('id_payment_method', 1)->sum('price');
        $data['bailsInvoices']['bancolombia'] = $this->getBailInvoice($type, $date)->where('id_payment_method', 4)->sum('price');
        $data['bailsInvoices']['nequi'] = $this->getBailInvoice($type, $date)->where('id_payment_method', 2)->sum('price');
        $data['bailsInvoices']['daviplata'] = $this->getBailInvoice($type, $date)->where('id_payment_method', 3)->sum('price');

        $data['expenses']['numExpenses'] = $this->getExpense($type, $date)->count();
        $data['expenses']['valueDay'] = $this->getExpense($type, $date)->sum('value');

        
        $data['balance']['balanceCash'] = $data['sales']['cash'] + $data['bails']['cash'] - $data['invoices']['cash'] - $data['bailsInvoices']['cash'] - $data['expenses']['valueDay'];
        $data['balance']['balanceNequi'] = $data['sales']['nequi'] + $data['bails']['nequi'] - $data['invoices']['nequi'] - $data['bailsInvoices']['nequi'];
        $data['balance']['balanceBancolombia'] = $data['sales']['bancolombia'] + $data['bails']['bancolombia'] - $data['invoices']['bancolombia'] - $data['bailsInvoices']['bancolombia'];
        $data['balance']['balanceDaviplata'] = $data['sales']['daviplata'] + $data['bails']['daviplata'] - $data['invoices']['daviplata'] - $data['bailsInvoices']['daviplata'];

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

    private function getBailInvoice(String $type, $date){
        if($type == 'month'){
            $rangeDates = $this->getLastDayMonth($date);
            return BailOrder::whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return BailOrder::whereDate('created_at', $date);
    }

    private function getInvoice(String $type, $date){
        if($type == 'month'){
            $rangeDates = $this->getLastDayMonth($date);
            return Order::whereMonth('created_at', $rangeDates['month'])->whereYear('created_at', $rangeDates['year']);
        }
        return Order::whereDate('created_at', $date);
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