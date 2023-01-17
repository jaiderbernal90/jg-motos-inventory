<?php

namespace App\Models\inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products_for_category";

    protected $fillable = ['product_id','sub_category_id','category_id'];

}
