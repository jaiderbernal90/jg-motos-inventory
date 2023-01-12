<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRole extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_role', 'id_user', 'type'];
}
