<?php   
namespace App\Models\setting;

use App\Models\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model{
    use SoftDeletes;
    
    protected $table = "roles";

    protected $fillable = ['name','description'];

    // public $timestamps = false;

    // Relacion uno a muchos rol con tabla pivote
    public function modulesForRole()
    {
        return $this->hasMany('App\Models\ModuleForRole');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'modules_for_roles')->withPivot('has_admin','selected');
    }
}