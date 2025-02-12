<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineList extends Model
{
    protected $table = 'medicine_list';
    protected $fillable = [
        'product_name', 'generic_name', 'category'
    ];

}
