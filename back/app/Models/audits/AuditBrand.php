<?php

namespace App\Models\audits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditBrand extends Model
{
    use HasFactory;

    protected $fillable = ['id_brand', 'id_user', 'type'];
}
