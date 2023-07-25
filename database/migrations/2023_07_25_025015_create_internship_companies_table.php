<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->string('since', 255);
            $table->json('sectors');
            $table->json('services');
            $table->text('address');
            $table->string('telephone', 255);
            $table->string('email', 255);
            $table->string('website', 255);
            $table->string('director', 255);
            $table->string('director_phone', 255);
            $table->text('advisors');
            $table->string('structure');
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
        Schema::dropIfExists('internship_companies');
    }
}
