<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_name',
        'address',
        'contact_email',
        'contact_phone',
        'tax_rate',
        'currency',
    ];
}
