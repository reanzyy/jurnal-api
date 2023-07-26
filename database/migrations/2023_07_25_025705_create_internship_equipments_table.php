<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->string('tool', 255);
            $table->string('specification', 255);
            $table->text('utility');
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
        Schema::dropIfExists('internship_equipments');
    }
}
