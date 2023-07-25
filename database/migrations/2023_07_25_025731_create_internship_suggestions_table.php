<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internship_id');
            $table->unsignedBigInteger('company_employee_id');
            $table->text('suggest');
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->string('approval_by');
            $table->timestamp('approval_at')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('internship_id')->references('id')->on('internships');
            // $table->foreign('company_employee_id')->references('id')->on('internship_company_employees');
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
        Schema::dropIfExists('internship_suggestions');
    }
}
