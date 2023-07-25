<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_drafts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->string('approval_status')->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('student_id')->references('id')->on('students');
            // $table->foreign('approval_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_drafts');
    }
}
