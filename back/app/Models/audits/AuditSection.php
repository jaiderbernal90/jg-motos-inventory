<?php

namespace App\Models\audits;

use App\Models\inventory\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditSection extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_section', 'id_user', 'type'];

     public function section()
    {
        return $this->belongsTo(Section::class, 'id_section')->withTrashed();
    }
}
