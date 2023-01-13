<?php   
namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model{
    use SoftDeletes;
    
    protected $table = "brands";

    protected $fillable = ['code','name'];

    // public $timestamps = false;
}