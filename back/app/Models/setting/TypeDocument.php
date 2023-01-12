<?php   
namespace App\Models\setting;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model{
    protected $table = "types_of_documents";

    protected $fillable = ['name','prefix'];

    // public $timestamps = false;
}