<?php

namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BailOrder extends Model
{
    use HasFactory;

    protected $table = "bails_orders";

    protected $fillable = ['id_order','id_payment_method','price'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
