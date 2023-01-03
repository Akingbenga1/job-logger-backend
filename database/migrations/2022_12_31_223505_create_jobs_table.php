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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string("summary", 150)->comment("summery or title of the Job.");
            $table->string("description", 500)->comment("Detailed description of the job to be done.");
            $table->enum('status', ['open', 'in progress','completed', 'cancelled'])->default('open')->comment("Completion status of the job .");;
            $table->unsignedBigInteger("property_id");
            $table->unsignedBigInteger("user_id");
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('property_id')->on('properties')->references('id')->onDelete('cascade');

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
