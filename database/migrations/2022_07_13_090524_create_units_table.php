<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_type_id');
            $table->string('name', 100)->fulltext()->comment('shop name, farm name, pond name');
            $table->string('code', 20)->nullable();
            $table->string('owner', 100);
            $table->boolean('as_dealer')->default(0);
            $table->string('mobile', 15)->unique();
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('upazila_id');
            $table->string('address', 255)->nullable();
            $table->double('latitude', 11, 8)->nullable();
            $table->double('longitude', 11, 8)->nullable();
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
        Schema::dropIfExists('units');
    }
}
