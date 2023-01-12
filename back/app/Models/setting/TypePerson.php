<?php   
namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;

class TypePerson extends Model{
    protected $table = "types_of_persons";

    protected $fillable = ['name'];

    // public $timestamps = false;
}