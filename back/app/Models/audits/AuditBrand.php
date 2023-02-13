<?php

namespace App\Models\audits;

use App\Models\inventory\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditBrand extends Model
{
    use HasFactory;

    protected $fillable = ['id_brand', 'id_user', 'type'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand')->withTrashed();
    }
}
