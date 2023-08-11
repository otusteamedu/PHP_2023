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
        Schema::create('playlist_tracks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('playlist_id')->unsigned();
            $table->foreign('playlist_id')->references('id')->on('playlists');
            $table->bigInteger('track_id')->unsigned();
            $table->foreign('track_id')->references('id')->on('tracks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_tracks');
    }
};
