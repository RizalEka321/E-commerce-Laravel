<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_logs';
    protected $fillable = [
        'id_logs',
        'aktivitas',
        'user',
    ];
}
