<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('classroom_id');
            $table->char('identity', 8)->unique();
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('blood_type', 255)->nullable();
            $table->string('parent_name', 255)->nullable();
            $table->string('parent_phone', 255)->nullable();
            $table->string('parent_address', 255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('password_hint', 255)->nullable();
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('school_year_id')->references('id')->on('school_years');
            // $table->foreign('classroom_id')->references('id')->on('classrooms');
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
