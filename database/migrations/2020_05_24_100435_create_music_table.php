<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE DATABASE IF NOT EXISTS " . config('database.connections.mysql.database'));

        Schema::create('music', function (Blueprint $table) {
            $table->string('uid');
            $table->string('sha1')->index();
            $table->integer('size');
            $table->string('name');
            $table->string('extension');
            $table->string('song_name', 1024);
            $table->string('artist');
            $table->string('album');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('music');
    }
}
