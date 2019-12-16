<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_id');
            $table->string('meter_id');
            $table->date('date');
            $table->double('price');
            $table->string('costcenter');
            $table->string('gl');
            $table->string('business_process');
            $table->string('product');
            $table->string('functional_area');
            $table->string('segment');
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
        Schema::dropIfExists('electrics');
    }
}
