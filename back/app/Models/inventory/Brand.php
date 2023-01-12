<?php   
namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model{
    protected $table = "brands";

    protected $fillable = ['code','name'];

    // public $timestamps = false;
}