<?php   
namespace App\Models\accounting;

use App\Models\contacts\Provider;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model{
    use SoftDeletes;

    protected $table = "orders";

    protected $fillable = ['reference','id_provider','payment_status','id_payment_method','due_date','total_bails','subtotal','tax','total','observations'];

    // public $timestamps = false;

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'id_provider');
    } 

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method');
    }

    public function bails()
    {
        return $this->hasMany(BailOrder::class,'id_order');
    }
}