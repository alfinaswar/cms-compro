<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contact_us', function (Blueprint $table) {
            $table->boolean('IsRead')->default(false)->after('Pesan');
            $table->timestamp('ReadAt')->nullable()->after('IsRead');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['IsRead', 'ReadAt']);
        });
    }
};
