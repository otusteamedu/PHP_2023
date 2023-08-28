<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks_playlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('tracks_id')->unsigned();
            $table->unsignedBiginteger('playlists_id')->unsigned();

            $table->foreign('tracks_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('cascade');

            $table->foreign('playlists_id')
                ->references('id')
                ->on('playlists')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks_playlists');
    }
};
