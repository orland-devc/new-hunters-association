<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordTimeIn extends Model {
    use HasFactory;

    protected $table = 'discord_time_in';

    protected $fillable = 
    [
        'discord_user_id', 
        'discord_username', 
        'discord_avatar', 
        'discord_discriminator', 
        'time_in', 
        'time_out'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'discord_user_id', 'discord_id');
    }
}
