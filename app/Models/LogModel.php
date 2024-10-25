<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table = 'log';
    protected $fillable = [
        'log',
        'created_at',
        'updated_at'
    ];
}
