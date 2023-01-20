<?php   
namespace App\Models\accounting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model{
    use SoftDeletes;

    protected $table = "orders";

    protected $fillable = ['reference','id_provider','statu_commodity','payment_status','id_payment_method','total_bails','subtotal','tax','total'];

    // public $timestamps = false;
}