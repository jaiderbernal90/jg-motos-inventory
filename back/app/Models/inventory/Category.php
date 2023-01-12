<?php   
namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    protected $table = "categories";

    protected $fillable = ['code','name'];

    // public $timestamps = false;
}