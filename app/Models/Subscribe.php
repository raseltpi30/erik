<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'subscribes';

    // Specify the fillable attributes
    protected $fillable = [
        'email',    // Assuming your table has an 'email' column
        'status',   // Assuming your table has a 'status' column
    ];
}
