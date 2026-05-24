<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'admin_id','total_price','status'
    ];

     protected $hidden = ['admin_id', 'admin']; 

    
    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}
