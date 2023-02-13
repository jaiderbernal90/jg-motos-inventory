<?php

namespace App\Models\audits;

use App\Models\accounting\BailOrder;
use App\Models\accounting\Order;
use App\Models\setting\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditOrder extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_order', 'id_user', 'id_bail_order', 'type'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user')->withTrashed();
    }

    public function bail()
    {
        return $this->belongsTo(BailOrder::class, 'id_bail_order')->withTrashed();
    }
}
