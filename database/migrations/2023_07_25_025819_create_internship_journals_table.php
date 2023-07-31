<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->date('date');
            $table->string('activity', 255);
            $table->string('activity_image', 255)->nullable();
            $table->unsignedBigInteger('competency_id');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->string('approval_by')->nullable();
            $table->timestamp('approval_at')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('internship_id')->references('id')->on('internships');
            // $table->foreign('competency_id')->references('id')->on('internship_competencies');
            // $table->foreign('approval_user_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_journals');
    }
}
