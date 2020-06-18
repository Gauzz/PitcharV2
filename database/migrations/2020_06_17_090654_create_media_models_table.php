<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('authtoken');
            $table->string('type')->default('2D,360,Audio');
            $table->string('video');
            $table->string('thumbnail');
            $table->string('audio');
            $table->string('name');
            $table->string('tags');
            $table->string('extension')->default('MP3/MP4/WEBM');
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
        Schema::dropIfExists('media');
    }
}
