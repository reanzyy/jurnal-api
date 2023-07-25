<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompanyRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_company_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->tinyInteger('sequence');
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
        Schema::dropIfExists('internship_company_rules');
    }
}
