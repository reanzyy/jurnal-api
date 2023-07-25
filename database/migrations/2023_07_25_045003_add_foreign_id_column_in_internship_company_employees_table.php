<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internship_company_employees', function (Blueprint $table) {
            $table->foreign('internship_id')->references('id')->on('internships')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('internship_company_job_titles')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internship_company_employees', function (Blueprint $table) {
            //
        });
    }
};