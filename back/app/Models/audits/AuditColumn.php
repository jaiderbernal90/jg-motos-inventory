<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditColumn extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_column', 'id_user', 'type'];
}
