<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ParentId')->nullable();
            $table->string('NamaMenu');
            $table->string('SlugMenu')->unique();
            $table->string('JenisLink')->default('custom');  // custom, route, page
            $table->string('Url')->nullable();
            $table->string('RouteName')->nullable();
            $table->string('Icon')->nullable();
            $table->integer('Urutan')->default(0);
            $table->boolean('StatusAktif')->default(true);
            $table->boolean('TampilkanDiHeader')->default(true);
            $table->boolean('TampilkanDiFooter')->default(false);
            $table->string('Target')->default('_self');  // _self, _blank
            $table->string('UserCreate')->nullable();
            $table->string('UserUpdate')->nullable();
            $table->string('UserDelete')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('ParentId')->references('id')->on('Menu')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Menu');
    }
};
