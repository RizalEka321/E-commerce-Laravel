<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'log';
    protected $primaryKey = 'id_log';
    protected $fillable = [
        'id_logs',
        'aktivitas',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
