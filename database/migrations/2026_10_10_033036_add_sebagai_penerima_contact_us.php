<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notification_email_recipient', function (Blueprint $table) {
            $table->boolean('TerimaEmail')->default(false)->after('StatusAktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_email_recipient', function (Blueprint $table) {
            $table->dropColumn('TerimaEmail');
        });
    }
};
