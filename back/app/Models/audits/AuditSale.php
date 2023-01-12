<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSale extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_sale', 'id_user', 'type'];
}
