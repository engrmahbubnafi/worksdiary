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
        Schema::create('company_units', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('zone_id')->nullable();
            $table->unsignedInteger('area_id')->nullable();
            $table->unsignedInteger('dealer_id')->nullable()->comment('unit_id');
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
        Schema::dropIfExists('company_units');
    }
};
