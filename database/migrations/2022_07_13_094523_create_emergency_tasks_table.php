<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 155);
            $table->integer('visit_id')->nullable();
            $table->integer('assign_to');
            $table->date('commited_date');
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
        Schema::dropIfExists('emergency_tasks');
    }
}
