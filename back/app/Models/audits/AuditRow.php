<?php

namespace App\Models\audits;

use App\Models\inventory\Row;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRow extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_row', 'id_user', 'type'];

    public function row()
    {
        return $this->belongsTo(Row::class, 'id_row')->withTrashed();
    }
}
