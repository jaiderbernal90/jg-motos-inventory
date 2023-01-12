<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_category', 'id_user', 'type'];
}
