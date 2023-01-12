<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditProduct extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_product', 'id_user', 'type'];
}
