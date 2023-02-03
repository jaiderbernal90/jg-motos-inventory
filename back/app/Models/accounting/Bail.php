<?php

namespace App\Models\accounting;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "bails";

    protected $fillable = ['id_sale','id_payment_method','price'];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'id_sale');
    }
    
}
