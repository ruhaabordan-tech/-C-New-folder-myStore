<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily_Expense extends Model
{
    protected $table = 'daily_expenses';
     protected $fillable = [
        'admin_id',
        'amount',
        'description',
        'date'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
