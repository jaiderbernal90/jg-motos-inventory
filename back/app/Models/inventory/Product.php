<?php   
namespace App\Models\inventory;

use App\Models\accounting\SalesDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model{
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = ['code','name','description','applications','reference','id_brand','images','stock','status','cost','price','tax','discount','price_total','barcode','id_section','id_column','id_row','original','stockMin'];

    // public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_for_category')->withPivot('product_id','sub_category_id');
    }

    public function sales_detail()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
