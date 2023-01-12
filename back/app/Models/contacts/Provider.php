<?php   
namespace App\Models\contacts;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model{
    protected $table = "providers";

    protected $fillable = ['nit','full_name','landline','cellphone','email','department','city','address'];

    // public $timestamps = false;
}