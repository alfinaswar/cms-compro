<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public const DEFAULT_AUTHOR_BIO = 'Penulis artikel ini telah berpengalaman di bidang IT dan teknologi. Ikuti tulisan-tulisannya untuk insight terbaru seputar dunia digital.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'bio_penulis')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('bio_penulis')->nullable()->after('email');
            });
        }

        DB::table('users')
            ->whereNull('bio_penulis')
            ->update(['bio_penulis' => self::DEFAULT_AUTHOR_BIO]);

        if (!Schema::hasColumn('beritas', 'user_id')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('Penulis')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        // Backfill user_id untuk berita lama berdasarkan kecocokan nama Penulis atau UserCreate
        $usersByName = DB::table('users')->pluck('id', 'name');
        foreach ($usersByName as $name => $userId) {
            DB::table('beritas')
                ->whereNull('user_id')
                ->where(function ($q) use ($name) {
                    $q->where('Penulis', $name)
                        ->orWhere('UserCreate', $name);
                })
                ->update(['user_id' => $userId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('beritas', 'user_id')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->dropConstrainedForeignId('user_id');
            });
        }

        if (Schema::hasColumn('users', 'bio_penulis')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('bio_penulis');
            });
        }
    }
};
