<?php   
namespace App\Models\contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model{
    use SoftDeletes;
    
    protected $table = "providers";

    protected $fillable = ['nit','full_name','landline','cellphone','email','department','city','address'];

    // public $timestamps = false;
}