<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompanyEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_company_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('job_title_id');
            $table->string('name', 255);
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('internship_id')->references('id')->on('internships');
            // $table->foreign('job_title_id')->references('id')->on('internship_company_job_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_company_employees');
    }
}
