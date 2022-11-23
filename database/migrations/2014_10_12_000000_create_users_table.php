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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('code', 13)->unique()->nullable();
            $table->string('mobile', 24)->nullable()->unique();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('avatar')->nullable();
            $table->string('status', 15)->default('active');
            $table->softDeletes();
            $table->unsignedMediumInteger('role_id')->index();
            $table->integer('department_id')->default('0');
            $table->integer('company_id')->default('0');
            $table->integer('supervisor_id')->default('0');
            $table->integer('designation_id')->default('0'); 
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
        Schema::dropIfExists('users');
    }
};
