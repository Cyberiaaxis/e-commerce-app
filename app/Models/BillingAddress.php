<?php

// app/Models/BillingAddress.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'phone'
    ];

    /**
     * Get the order that owns the billing address.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
