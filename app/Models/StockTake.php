<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTake extends Model
{
    protected $fillable = ['medicine_id', 'physical_quantity', 'system_quantity', 'discrepancy', 'notes'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
