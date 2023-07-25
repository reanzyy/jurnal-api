<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_advisors', function (Blueprint $table) {
            $table->id();
            $table->string('identity', 255);
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('address', 255);
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('password_hint', 255)->nullable();
            $table->timestamps();

            // Define foreign key constraints
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_advisors');
    }
}
