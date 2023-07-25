<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_advisors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('identity', 255);
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->enum('gender', ['male', 'female']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('password_hint', 255)->nullable();
            $table->timestamps();

            // Define foreign key constraint for 'company_id' column
            // $table->foreign('company_id')->references('id')->on('companies');
            // Define foreign key constraint for 'user_id' column
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
        Schema::dropIfExists('company_advisors');
    }
}
