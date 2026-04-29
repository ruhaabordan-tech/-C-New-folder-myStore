<?php

namespace App\Models;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table='categories';
    protected $fillable = [
        'name',
        'admins_id'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
