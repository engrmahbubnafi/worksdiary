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
            $table->id();
            $table->string('name');
            $table->integer('visit_id')->nullable();
            $table->integer('unit_type_id')->comment('child of unit type');
            $table->integer('company_unit_id');
            $table->integer('zone_id')->comment('report purpose');
            $table->integer('company_id')->comment('report purpose');
            $table->integer('unit_id')->comment('report purpose');
            $table->date('date_for');
            $table->integer('assign_to')->nullable();
            $table->integer('priority')->default(0);
            $table->string('status', 25)->default('pending');
            $table->string('task_note', 200)->nullable();
            $table->string('comments', 200)->nullable();
            $table->dateTime('completed_at')->nullable();
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
