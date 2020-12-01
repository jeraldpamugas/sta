<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactionlines extends Model
{
    use HasFactory;
    protected $fillable = [
        'transNo', 
        'itemCode',
        'unit',
        'qauntity'
    ];
}
