<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompetenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_competencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->string('competency', 255);
            $table->text('description');
            $table->timestamps();

            // Define foreign key constraint for 'internship_id' column
            // $table->foreign('internship_id')->references('id')->on('internships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_competencies');
    }
}
