<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'artwork', 'lease_duration',
        'budget_range', 'message', 'status',
    ];
}
