<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $primaryKey = 'id_log';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'menu',
        'aktivitas',
        'keterangan',
        'ip_address',
        'user_agent'
    ];

    // RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}