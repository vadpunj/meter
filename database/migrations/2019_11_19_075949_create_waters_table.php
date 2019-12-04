<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('TIME_KEY');
            $table->char('ASSET_ID')->nullable();
            $table->char('COST_CENTER');
            $table->char('METER_ID');
            $table->integer('M_UNIT');
            $table->double('M_UNIT_PRICE');
            $table->double('M_Cost_TOTAL')->nullable();
            $table->char('ACTIVITY_CODE');
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
        Schema::dropIfExists('waters');
    }
}
