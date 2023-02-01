<?php   
namespace App\Models\contacts;

use App\Models\accounting\Sale;
use App\Models\setting\TypeDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model{
    use SoftDeletes;
    
    protected $table = "customers";

    protected $fillable = ['id_type_person','full_name','id_type_document','document','cellphone','email','address'];

    // public $timestamps = false;

    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class, 'id_type_document');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class,'id_customer');
    }


    public function salesPending()
    {
        return $this->hasMany(Sale::class,'id_customer')->where('status', 2);
    }


   

}