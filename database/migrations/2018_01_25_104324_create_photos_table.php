<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(NULL)->change();
            $table->integer('post_id')->default(NULL)->change();
            $table->integer('comment_id')->default(NULL)->change();
            $table->integer('is_thumbnail')->default(0)->change();
            $table->integer('is_active')->default(1)->change();
            $table->string('path')->default("No image")->change();
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
        Schema::dropIfExists('photos');
    }
}
