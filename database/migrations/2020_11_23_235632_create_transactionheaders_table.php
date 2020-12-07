<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionheadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactionheaders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("transNo");
            $table->integer("employeeCode");
            $table->dateTime('transferDate');
            $table->string("warehouseFrom", 4);
            $table->string("warehouseTo", 4);
            $table->string("reference", 30);
            $table->char("status", 1)->default('O');
            $table->integer("authorizedBy")->nullable();
            $table->dateTime("authorizedDate")->nullable();
            $table->integer("confirmedBy")->nullable();
            $table->dateTime("confirmedDate")->nullable();
            $table->integer("processedBy")->nullable();
            $table->dateTime("processedDate")->nullable();
            $table->timestamp("created_at")->nullable();
            $table->integer("syscreator")->nullable();
            $table->timestamp("updated_at")->nullable();
            $table->integer("sysmodifier")->nullable();
            $table->boolean("isOpened")->default(0);
        });
        DB::statement("ALTER TABLE transactionheaders AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactionheaders');
    }
}
