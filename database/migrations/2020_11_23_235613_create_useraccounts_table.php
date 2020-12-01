<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseraccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useraccounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("code");
            $table->string("fullname", 90)->nullable();
            $table->string("usertype", 15)->nullable();
            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();
        });
        DB::statement("ALTER TABLE useraccounts AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('useraccounts');
    }
}
