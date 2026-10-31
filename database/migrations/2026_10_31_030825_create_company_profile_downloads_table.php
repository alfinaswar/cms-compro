<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profile_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('Nama');
            $table->string('Email');
            $table->string('Perusahaan')->nullable();
            $table->string('NoHp')->nullable();
            $table->string('IpAddress', 45)->nullable();
            $table->text('UserAgent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profile_downloads');
    }
};
