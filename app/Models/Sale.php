<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', 'quantity', 'total_amount', 'medicine_id',
    ];
    public function staff(){
        return $this->belongsTo(User::class, 'staff_id', 'id');
    }
    public function medicine(){
        return $this->belongsTo(MedicineList::class, 'medicine_id', 'id');
    }
}
