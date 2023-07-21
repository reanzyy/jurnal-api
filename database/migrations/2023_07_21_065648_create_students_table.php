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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 8);
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('birth_date', 255);
            $table->string('birth_place', 255);
            $table->string('region', 255);
            $table->string('gender', 255);
            $table->string('address', 255);
            $table->string('photo', 255);
            $table->string('blood_type', 255);
            $table->string('parent_name', 255);
            $table->string('parent_phone', 255);
            $table->string('parent_address', 255);
            $table->foreignId('school_year_id')->nullable();
            $table->foreignId('classroom_id')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
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
};
