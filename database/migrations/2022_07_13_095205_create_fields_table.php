<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
            $table->string('name', 75)->unique();
            $table->integer('field_group_id')->nullable();
            $table->integer('length');
            $table->integer('sequence')->default(0);
            $table->string('reference_value')->nullable()->comment('fomula');
            $table->integer('compare_value')->nullable()->comment('source_id');
            $table->integer('field_type_id')->nullable();
            $table->boolean('is_required')->default(0);
            $table->boolean('is_reportable')->default(0);
            $table->boolean('is_formula')->default(0);
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
        Schema::dropIfExists('fields');
    }
}
