<?php

namespace App\Models\audits;

use App\Models\inventory\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_category', 'id_user', 'type'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category')->withTrashed();
    }
}
