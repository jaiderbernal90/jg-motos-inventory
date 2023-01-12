<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCustomer extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_customer', 'id_user', 'type'];
}
