<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = false;

    const HOURLY_PAYMENT = 200;
    const STATUS_OPEN = 0;
    const STATUS_CONDUCTED = 1;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
