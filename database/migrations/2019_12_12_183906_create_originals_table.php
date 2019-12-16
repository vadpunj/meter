<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOriginalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('originals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meter_id');
            $table->string('utility')->nullable();
            $table->string('utility_type');
            $table->string('business_id')->nullable();
            $table->string('node1')->nullable();
            $table->string('node2')->nullable();
            $table->string('costcenter')->nullable();
            $table->string('gl')->nullable();
            $table->string('business_process')->nullable();
            $table->string('product')->nullable();
            $table->string('functional_area')->nullable();
            $table->string('segment')->nullable();
            $table->string('key1');
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
        Schema::dropIfExists('originals');
    }
}
