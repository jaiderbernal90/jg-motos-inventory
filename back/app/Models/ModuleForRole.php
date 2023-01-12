<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleForRole extends Model
{
    use HasFactory;

    protected $table = "modules_for_roles";
    
    protected $fillable = ['module_id','role_id', 'has_admin', 'selected'];

    //Relación uno a muchos rol con tabla pivote (inversa)
    public function role()
    {
        return $this->belongsTo('App\Models\setting\Role');
    }

    //Relación uno a muchos modulo con tabla pivote (inversa)
    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }
}
