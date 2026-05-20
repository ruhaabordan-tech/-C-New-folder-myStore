<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyExpense extends Model
{
    protected $table = 'dailyexpenses';
     protected $fillable = [
        'admin_id',
        'amount',
        'reason',
        'entry_date'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}