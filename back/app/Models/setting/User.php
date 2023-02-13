<?php

namespace App\Models\setting;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['full_name','id_type_document','document','status','avatar','email','id_role','password','date_birth','phone'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function auditUsers()
    {
        return $this->hasMany(AuditUser::class, 'id_user');
    }

    public function auditRoles()
    {
        return $this->hasMany(AuditRole::class, 'id_user');
    }

    public function auditBrands()
    {
        return $this->hasMany(AuditBrand::class, 'id_user');
    }

    public function auditCategories()
    {
        return $this->hasMany(AuditCategory::class, 'id_user');
    }

    public function auditColumns()
    {
        return $this->hasMany(AuditColumn::class, 'id_user');

    }

    public function auditCustomers()
    {
        return $this->hasMany(AuditCustomer::class, 'id_user');   
    }

    public function auditExpenses()
    {
        return $this->hasMany(AuditExpense::class, 'id_user');   
    }

    public function auditLogin()
    {
        return $this->hasMany(AuditLogin::class, 'id_user');   
    }

    public function auditOrders()
    {
        return $this->hasMany(AuditOrder::class, 'id_user');   
    }

    public function auditProducts()
    {
        return $this->hasMany(AuditProduct::class, 'id_user');   
    }

    public function auditProviders()
    {
        return $this->hasMany(AuditProvider::class, 'id_user');   
    }

    public function auditRows()
    {
        return $this->hasMany(AuditRow::class, 'id_user');   
    }

    public function auditSales()
    {
        return $this->hasMany(AuditSale::class, 'id_user');   
    }

    public function auditSections()
    {
        return $this->hasMany(AuditSection::class, 'id_user');   
    }

    public function auditSubCategories()
    {
        return $this->hasMany(AuditSubCategory::class, 'id_user');   
    }

}
