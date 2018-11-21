<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetPrintersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('det_printers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_printer')
                -refrences('id')->on('printers');
            $table->integer('id_jasa')
                ->refrences('id')->on('jasas');
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
        Schema::dropIfExists('det_printers');
    }
}
