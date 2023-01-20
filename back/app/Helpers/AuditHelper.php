<?php

namespace App\Helpers;

use App\Models\audits\AuditBrand;
use App\Models\audits\AuditCategory;
use App\Models\audits\AuditColumn;
use App\Models\audits\AuditCustomer;
use App\Models\audits\AuditExpense;
use App\Models\audits\AuditLogin;
use App\Models\audits\AuditOrder;
use App\Models\audits\AuditProduct;
use App\Models\audits\AuditProvider;
use App\Models\audits\AuditRole;
use App\Models\audits\AuditRow;
use App\Models\audits\AuditSale;
use App\Models\audits\AuditSection;
use App\Models\audits\AuditSubCategory;
use App\Models\audits\AuditUser;
use Illuminate\Support\Facades\Auth;

class AuditHelper
{
    public $id;

    //Class constructor
    public function __construct(){
        $this->id = @Auth::user()->id;
    }

    //General module methods
    public function auditRole(Int $id, Int $method){ 
        try {
            AuditRole::create([
                'id_role' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditUser(Int $id, Int $method){ 
        try {
            AuditUser::create([
                'id_user_create' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditBrand(Int $id, Int $method){ 
        try {
            AuditBrand::create([
                'id_brand' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditCategory(Int $id, Int $method){ 
        try {
            AuditCategory::create([
                'id_category' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditSubCategory(Int $id, Int $method){ 
        try {
            AuditSubCategory::create([
                'id_sub_category' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditCustomer(Int $id, Int $method){ 
        try {
            AuditCustomer::create([
                'id_customer' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditProvider(Int $id, Int $method){ 
        try {
            AuditProvider::create([
                'id_provider' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditOrder(Int $id, Int $method){ 
        try {
            AuditOrder::create([
                'id_order' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditProduct(Int $id, Int $method){ 
        try {
            AuditProduct::create([
                'id_product' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditSale(Int $id, Int $method){ 
        try {
            AuditSale::create([
                'id_sale' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditSection(Int $id, Int $method){ 
        try {
            AuditSection::create([
                'id_section' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditRow(Int $id, Int $method){ 
        try {
            AuditRow::create([
                'id_row' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditColumn(Int $id, Int $method){ 
        try {
            AuditColumn::create([
                'id_column' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditExpense(Int $id, Int $method){ 
        try {
            AuditExpense::create([
                'id_expense' => $id,
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }

    public function auditLogin(Int $method){ 
        try {
            AuditLogin::create([
                'id_user' => $this->id,
                'type' => $method,
            ]);

            return true;
        } catch (\Throwable $th) {
            return ResponseHelper::Error($th, 'La auditoria no pudo ser creada');
        }
    }
}