<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model{
    protected $table = "locals";

    protected $casts = [
        'logo' => 'array'
    ];

    protected $fillable = ['code', 'name', 'nit', 'cellphone', 'department', 'city', 'direction ', 'logo'];

    // public $timestamps = false;
}