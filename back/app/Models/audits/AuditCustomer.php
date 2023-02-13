<?php

namespace App\Models\audits;

use App\Models\contacts\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCustomer extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_customer', 'id_user', 'type'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer')->withTrashed();
    }
}
