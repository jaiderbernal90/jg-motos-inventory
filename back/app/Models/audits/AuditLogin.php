<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLogin extends Model
{
    use HasFactory;

    protected $table = "audit_login";
    
    protected $fillable = ['id_user', 'type'];
}
