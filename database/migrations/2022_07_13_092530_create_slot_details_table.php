<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slot_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slot_id');
            $table->float('area');
            $table->float('depth');
            $table->float('density');
            $table->date('harvest_date');
            $table->string('fry_source', 75);
            $table->date('stocking_date');
            $table->string('species', 75);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slot_details');
    }
};
