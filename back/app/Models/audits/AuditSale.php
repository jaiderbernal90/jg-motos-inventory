<?php

namespace App\Models\audits;

use App\Models\accounting\Bail;
use App\Models\accounting\Sale;
use App\Models\setting\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSale extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_sale', 'id_user','id_bail', 'type'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'id_sale')->withTrashed();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();
    }

    public function bail()
    {
        return $this->belongsTo(Bail::class, 'id_bail')->withTrashed();
    }
}
