<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_companies', function (Blueprint $table) {
            $table->id(); // This sets the 'id' column as the primary key and auto-incrementing.
            $table->bigInteger('internship_id')->unsigned()->notNull();
            $table->integer('since')->notNull();
            $table->json('sectors');
            $table->json('services');
            $table->text('address');
            $table->string('telephone', 255);
            $table->string('email', 255);
            $table->string('website', 255);
            $table->string('director', 255);
            $table->string('director_phone', 255);
            $table->text('advisors');
            $table->string('structure', 255);
            $table->timestamps(); // This creates 'created_at' and 'updated_at' columns.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_companies');
    }
}
