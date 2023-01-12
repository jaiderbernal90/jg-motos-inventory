<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRow extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_row', 'id_user', 'type'];
}
