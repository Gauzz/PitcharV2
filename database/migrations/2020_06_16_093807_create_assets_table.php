<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('authtoken');
            $table->string('type')->default('OBJ,FBX,IMAGE');
            $table->string('objthumbnail');
            $table->string('obj');
            $table->string('mtl');
            $table->string('gltf');
            $table->string('fbx');
            $table->string('image');
            $table->string('name');
            $table->string('tags');

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
        Schema::dropIfExists('assets');
    }
}
