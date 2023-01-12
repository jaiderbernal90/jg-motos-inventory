<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSection extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_section', 'id_user', 'type'];
}
