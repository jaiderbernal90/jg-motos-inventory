<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditProvider extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_provider', 'id_user', 'type'];
}
