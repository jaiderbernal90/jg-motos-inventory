<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\accounting\Order;
use App\Models\accounting\Sale;
use App\Models\accounting\SalesDetail;
use App\Models\contacts\Customer;
use App\Models\contacts\Provider;
use App\Models\inventory\Product;
use App\Models\setting\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   

    /**
     * to earn an income 
     */
    public function getSales()
    {
        $data = $this->getSale();

        return ResponseHelper::Get($data);
    }

    /**
     * to earn an income 
     */
    public function getCountSales()
    {
        $data = Sale::count();

        return ResponseHelper::Get($data);
    }

     /**
     * to earn an income 
     */
    public function getCountProducts()
    {
        $data = Product::count();

        return ResponseHelper::Get($data);
    }

    /**
        * to earn an income 
    */
    public function getValueProducts()
    {
        $products = Product::sum(DB::raw('cost * stock'));
        
        return ResponseHelper::Get($products);
    }

    /**
     * GET TOP PRODUCTS ON SALES
    */
    public function getTopProducts(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 5;
        $term = $request->get('term');

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        $data = Product::with(['categories' => function ($query) { 
            $query->select('categories.id as category_id','categories.name as name_category','sub_categories.name as name_subcategory','sub_categories.id as sub_category_id');
            $query->leftjoin('sub_categories', 'sub_categories.id', '=', 'products_for_category.sub_category_id');
        }])
        ->withSum('sales_detail','amount')
        ->withSum('sales_detail','price')
        ->orderBy('sales_detail_sum_amount','DESC')
        ->paginate($limit);
        
        return ResponseHelper::Get($data);
    }

    /**
     * to earn an income 
    */
    public function getCountClients()
    {
        $data = Customer::count();

        return ResponseHelper::Get($data);
    }

    /**
     * to earn an income 
    */
    public function getCountUsers()
    {
        $data = User::count();

        return ResponseHelper::Get($data);
    }


    public function getRecentSales(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 5;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        $data = Sale::select('sales.*')
        ->with(['customer' => function ($query) { 
            $query->select('id','full_name', 'id_type_document','document');
            $query->with(['typeDocument:id,prefix']);
        },'paymentMethod:id,name'])->orderBy('id', 'DESC')->paginate($limit);
        
        return ResponseHelper::Get($data);
    }

    public function getTopClients(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 5;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        
        $data = Customer::select('full_name','id')->whereHas('sales')->withCount('sales')->orderBy('sales_count', 'DESC')->paginate($limit);
        
        return ResponseHelper::Get($data);
    }

    public function getTopDebtors(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 5;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Customer::select('full_name','id','id_type_document','document')
        ->whereHas('salesPending')
        ->with(['typeDocument','sales' => function ($query) { 
            $query->where('status', 2);
            $query->whereNotNull('total_bails');
        }])
        ->withCount(['sales' => function ($query) { 
            $query->where('status', 2);
        }])
        ->withSum('sales', (DB::raw('total - sales.total_bails')))
        ->orderBy('sales_sum_total_salestotal_bails','DESC')
        ->paginate($limit);
        
        return ResponseHelper::Get($data);
    }

    
    public function getTopInvoices(Request $request)
    {
        $data = [];
        $page = $request->get('page') ? $request->get('page') : 1;
        $limit = $request->get('limit') ? $request->get('limit') : 5;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $data = Provider::select('full_name','nit','id')
                ->whereHas('orders')
                ->withCount(['orders' => function ($query) { 
                    $query->where('payment_status', 2);
                }])
                ->with(['orders' => function ($query) { 
                    $query->select('id','payment_status', 'due_date','total_bails','total','id_provider');
                    $query->where('payment_status', 2);
                    $query->orderBy('due_date','DESC');
                }])
                ->withSum('orders',(DB::raw('total - orders.total_bails')))
                ->orderBy('orders_sum_total_orderstotal_bails','DESC')
                ->paginate($limit);
        
        return ResponseHelper::Get($data);
    }
    


    private function getSale():Int { return Sale::where('status', 1)->sum('total'); } 
}
