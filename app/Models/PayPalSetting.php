<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayPalSetting extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default (plural form of the model name)
    protected $table = 'paypal_settings';

    // Define the fillable attributes
    protected $fillable = [
        'client_id', 
        'secret', 
        'mode', // either 'sandbox' or 'live'
    ];

    // Optionally, you can define hidden attributes that should not be visible
    protected $hidden = [
        'secret', // Don't expose the secret key in any API responses
    ];

    // Optionally, you can cast some fields to specific data types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

