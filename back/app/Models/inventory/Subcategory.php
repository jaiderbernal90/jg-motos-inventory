<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = "sub_categories";

    protected $fillable = ['code','name','id_category'];

    // public $timestamps = false;
}
