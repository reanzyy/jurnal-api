<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('school_advisor_id');
            $table->unsignedBigInteger('company_advisor_id')->nullable();
            $table->enum('working_day', ['mon-fri', 'mon-sat']);
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('school_year_id')->references('id')->on('school_years');
            // $table->foreign('student_id')->references('id')->on('students');
            // $table->foreign('company_id')->references('id')->on('companies');
            // $table->foreign('school_advisor_id')->references('id')->on('school_advisors');
            // $table->foreign('company_advisor_id')->nullable()->references('id')->on('company_advisors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internships');
    }
}
