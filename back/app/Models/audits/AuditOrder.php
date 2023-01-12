<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditOrder extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_order', 'id_user', 'type'];
}
