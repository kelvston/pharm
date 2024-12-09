<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id', 'category_id', 'quantity', 'unit_price', 'sell_price', 'unit_cost', 'expiry_date',
    ];

    public function category(){
        return $this->hasMany('App\Models\Category','id','category_id');
    }
    public function medicinelist(){
        return $this->hasMany('App\Models\MedicineList','id','medicine_id');
    }
}
