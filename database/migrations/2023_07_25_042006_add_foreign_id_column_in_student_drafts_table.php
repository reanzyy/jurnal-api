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
        Schema::table('student_drafts', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('approval_user_id')->references('id')->on('users')
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
        Schema::table('student_drafts', function (Blueprint $table) {
            //
        });
    }
};
