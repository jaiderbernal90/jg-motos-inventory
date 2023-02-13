<?php

namespace App\Models\audits;

use App\Models\inventory\Subcategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSubCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_sub_category', 'id_user', 'type'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'id_sub_category')->withTrashed();
    }
}
