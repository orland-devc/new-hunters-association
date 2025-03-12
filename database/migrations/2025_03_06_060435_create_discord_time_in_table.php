<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('discord_time_in', function (Blueprint $table) {
            $table->id();
            $table->string('discord_user_id');
            $table->string('discord_username');
            $table->string('discord_avatar')->nullable();
            $table->string('discord_discriminator')->nullable();
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('discord_time_in');
    }
};
