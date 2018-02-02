<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

date_default_timezone_set("Asia/Ho_Chi_Minh");

class CreateRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->timestamps();
        });
        
        $times  = date('Y:m:d H:i:s', time());
        DB::table('roles')->insert(
                array(
                    ['name' => 'Admin', 'created_at' => $times, 'updated_at' => $times],
                    ['name' => 'Employee', 'created_at' => $times, 'updated_at' => $times],
                    ['name' => 'User', 'created_at' => $times, 'updated_at' => $times]
                )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('roles');
    }

}
