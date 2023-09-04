<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class NotificationLog extends Model
{
    use HasFactory;
    protected $table = 'notification_logs';
    protected $fillable = [
        'notification_to',
        'notification_from',
        'title',
        'message',
        'url',
    ];


    public function userNotification(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'notification_id');
    }

}
