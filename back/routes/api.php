<?php

use App\Http\Controllers\accounting\BailController;
use App\Http\Controllers\accounting\ExpenseController;
use App\Http\Controllers\accounting\SaleController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\inventory\BrandController;
use App\Http\Controllers\inventory\CategoryController;
use App\Http\Controllers\contacts\ProviderController;
use App\Http\Controllers\contacts\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\inventory\ColumnController;
use App\Http\Controllers\inventory\LocalController;
use App\Http\Controllers\inventory\ProductController;
use App\Http\Controllers\inventory\RowController;
use App\Http\Controllers\inventory\SectionController;
use App\Http\Controllers\inventory\SubcategoryController;
use App\Http\Controllers\reports\ReportController;
use App\Http\Controllers\setting\UserController;
use App\Http\Controllers\setting\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::controller(AuthController::class)->group(function (){
        Route::get('user-profile', 'userProfile');
        Route::get('logout', 'logout');
    });

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function (){
        Route::get('getSales', 'getSales');
        Route::get('getCountSales', 'getCountSales');
        Route::get('getCountProducts', 'getCountProducts');
        Route::get('getValueProducts', 'getValueProducts');
        Route::get('getTopProducts', 'getTopProducts');
        Route::get('getCountClients', 'getCountClients');
        Route::get('getCountUsers', 'getCountUsers');
        Route::get('getRecentSales', 'getRecentSales');
        Route::get('getTopClients', 'getTopClients');
    });

    Route::controller(UserController::class)->prefix('users')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getTypeDocuments', 'getTypeDocuments');
        Route::post('validatePassword', 'validatePassword');
        Route::put('changePassword', 'changePassword');
        Route::get('exportExcel', 'exportExcel');
        
    });

    Route::controller(RoleController::class)->prefix('roles')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getModules', 'getModules');
    });

    Route::controller(CategoryController::class)->prefix('categories')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getCount', 'getCount');
    });

    Route::controller(SubcategoryController::class)->prefix('subcategories')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getCount', 'getCount');
    });

    Route::controller(BrandController::class)->prefix('brands')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
    });

    Route::controller(ProviderController::class)->prefix('providers')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('exportExcel', 'exportExcel');
    });

    Route::controller(CustomerController::class)->prefix('customers')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getTypePersons', 'getTypePersons');
        Route::post('getForDocuments', 'getForDocuments');
        Route::get('exportExcel', 'exportExcel');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('consultAvailability/{id}', 'consultAvailability');
        Route::get('getCount', 'getCount');
        Route::get('getForReference/{reference}', 'getForReference');
        Route::get('exportExcel', 'exportExcel');
        Route::post('importExcel', 'importExcel');
    });

    Route::controller(SaleController::class)->prefix('sales')->group(function (){
        Route::post('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getPaymentMethods', 'getPaymentMethods');
        Route::get('getCount', 'getCount');
        Route::delete('destroyDetail/{id}', 'destroyDetail');
        Route::get('downloadInvoice/{id}', 'downloadInvoice');
    });

    Route::controller(BailController::class)->prefix('bails')->group(function (){
        Route::post('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
    });

    Route::controller(BrandController::class)->prefix('brands')->group(function (){
        Route::get('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
        Route::get('getCount', 'getCount');
    });

    Route::prefix('local')->group(function (){
        Route::controller(SectionController::class)->prefix('sections')->group(function (){
            Route::get('index', 'index');
            Route::post('create', 'create');
            Route::get('show/{id}', 'show');
            Route::post('update/{id}', 'update');
            Route::delete('destroy/{id}', 'destroy');
            Route::post('getRowsSelect', 'getRowsSelect');
            Route::post('getColumnsSelect', 'getColumnsSelect');
            Route::get('getCount', 'getCount');

        });
        Route::controller(RowController::class)->prefix('rows')->group(function (){
            Route::post('index', 'index');
            Route::post('create', 'create');
            Route::get('show/{id}', 'show');
            Route::post('update/{id}', 'update');
            Route::delete('destroy/{id}', 'destroy');
            Route::get('getCount', 'getCount');
        });
        Route::controller(ColumnController::class)->prefix('columns')->group(function (){
            Route::post('index', 'index');
            Route::post('create', 'create');
            Route::get('show/{id}', 'show');
            Route::post('update/{id}', 'update');
            Route::delete('destroy/{id}', 'destroy');
            Route::get('getCount', 'getCount');
        });
    });

    Route::controller(ExpenseController::class)->prefix('expenses')->group(function (){
        Route::post('index', 'index');
        Route::post('create', 'create');
        Route::get('show/{id}', 'show');
        Route::post('update/{id}', 'update');
        Route::delete('destroy/{id}', 'destroy');
    });

    Route::controller(ReportController::class)->prefix('reports')->group(function (){
        Route::post('closingDayling', 'closingDayling');
    });
});
