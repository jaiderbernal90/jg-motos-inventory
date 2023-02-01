<?php   
namespace App\Models\contacts;

use App\Models\accounting\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model{
    use SoftDeletes;
    
    protected $table = "providers";

    protected $fillable = ['nit','full_name','landline','cellphone','email','department','city','address'];

    // public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class,'id_provider');
    }
}