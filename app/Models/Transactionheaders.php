<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactionheaders extends Model
{
    use HasFactory;
    protected $fillable = [
        'transNo', 
        'employeeCode',
        'transferDate',
        'warehouseFrom',
        'warehouseTo',
        'reference',
        'status',
        'authorizedBy',
        'authorizedDate',
        'confirmedBy',
        'confirmedDate',
        'processedBy',
        'processedDate',
        'created_at',
        'syscreator',
        'updated_at',
        'sysmodifier',
        'isOpened'
    ];
}
