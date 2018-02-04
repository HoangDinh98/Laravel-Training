<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->text('title')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::table('posts', function($table) {
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('cascade');
        });

        DB::statement('ALTER TABLE posts ADD FULLTEXT fulltext_index (title, body)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('posts', function($table) {
            $table->dropIndex('fulltext_index');
        });
        
        Schema::dropIfExists('posts');
    }

}
