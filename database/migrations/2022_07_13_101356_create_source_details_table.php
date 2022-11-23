<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id');
            $table->float('from')->nullable();
            $table->float('to')->nullable();
            $table->string('value', 100);
            $table->boolean('is_default')->default(0);
            $table->string('status', 15)->default('active');
            $table->timestamps();
            $table->authors();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_details');
    }
}
