<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditUser extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_user_create', 'id_user', 'type'];
}
