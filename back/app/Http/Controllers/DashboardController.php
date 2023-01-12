<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\accounting\Sale;
use App\Models\accounting\SalesDetail;
use App\Models\contacts\Customer;
use App\Models\inventory\Product;
use App\Models\setting\User;
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
        $data = Sale::where('status', 1)->sum('total');

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
        $data = Product::sum('price_total');

        return ResponseHelper::Get($data);
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
}
