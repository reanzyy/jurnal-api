<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_year_id');
            $table->tinyInteger('sequence');
            $table->text('description');
            $table->timestamps();

            // Define foreign key constraint for 'school_year_id' column
            // $table->foreign('school_year_id')->references('id')->on('school_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_rules');
    }
}
