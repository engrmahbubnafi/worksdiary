<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75)->unique();
            $table->integer('number_of_fields')->nullable();
            $table->boolean('is_multiple')->default(0);
            $table->string('time_duration_unit', 5)->default('days');
            $table->string('status', 15)->default('active');
            $table->integer('company_id');
            $table->integer('unit_type_id');
            $table->boolean('is_skippable')->default(0);
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
        Schema::dropIfExists('forms');
    }
}
