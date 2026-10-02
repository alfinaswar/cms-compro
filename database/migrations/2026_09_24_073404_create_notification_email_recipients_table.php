<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notification_email_recipient', function (Blueprint $table) {
            $table->id();
            $table->string('Email')->unique();
            $table->string('Nama')->nullable();
            $table->boolean('StatusAktif')->default(true);
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_email_recipient');
    }
};
