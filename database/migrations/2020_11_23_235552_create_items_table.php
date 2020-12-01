<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string("itemCode", 30);
            $table->string("Description", 70)->nullable();
            $table->string("unit", 10);
            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();
        });
        DB::statement("ALTER TABLE items AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
