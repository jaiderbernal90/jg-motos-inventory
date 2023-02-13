<?php

namespace App\Models\audits;

use App\Models\setting\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRole extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_role', 'id_user', 'type'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role')->withTrashed();
    }

}
