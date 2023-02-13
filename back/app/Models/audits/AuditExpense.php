<?php

namespace App\Models\audits;

use App\Models\accounting\Expense;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditExpense extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_expense', 'id_user', 'type'];

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'id_expense')->withTrashed();
    }
}
