<?php

namespace App\Models\audits;

use App\Models\setting\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditUser extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_user_create', 'id_user', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user_create')->withTrashed();
    }

}
