<?php

namespace App\Models\accounting;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BailOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "bails_orders";

    protected $fillable = ['id_order','id_payment_method','price'];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function orderNotPaid()
    {
        return $this->belongsTo(Order::class, 'id_order')->where('payment_status', 2);
    }
}
