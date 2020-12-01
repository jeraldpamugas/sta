<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactionlines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("transNo");
            $table->string("itemCode");
            $table->string("unit");
            $table->decimal("quantity")->default(0);
            $table->timestamp("created_at")->nullable();
            $table->timestamp("updated_at")->nullable();
        });
        DB::statement("ALTER TABLE transactionlines AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactionlines');
    }
}
