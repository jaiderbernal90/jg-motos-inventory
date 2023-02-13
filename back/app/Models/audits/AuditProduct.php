<?php

namespace App\Models\audits;

use App\Models\inventory\Product;
use App\Models\setting\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditProduct extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_product', 'id_user', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();
    }
}
