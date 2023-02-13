<?php

namespace App\Models\audits;

use App\Models\inventory\Column;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditColumn extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_column', 'id_user', 'type'];

    public function column()
    {
        return $this->belongsTo(Column::class, 'id_column')->withTrashed();
    }
}
