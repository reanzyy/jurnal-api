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
        Schema::table('internships', function (Blueprint $table) {
            $table->foreign('school_year_id')
                ->references('id')->on('school_years')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('school_advisor_id')
                ->references('id')->on('school_advisors')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('company_advisor_id')
                ->references('id')->on('company_advisors')
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
        Schema::table('internships', function (Blueprint $table) {
            $table->dropForeign(['school_year_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['company_id']);
            $table->dropForeign(['school_advisor_id']);
            $table->dropForeign(['company_advisor_id']);
        });
    }
};
