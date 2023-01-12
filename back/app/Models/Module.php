<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model{
    protected $table = "modules";

    protected $fillable = ['selected','has_admin'];

    // public $timestamps = false;

     // Relacion uno a muchos modulo con tabla pivote
     public function modulesForRole()
     {
         return $this->hasMany('App\Models\ModuleForRole', 'id_module');
     }
}