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
    Schema::create('service_inquiries', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('service_id');
        $table->string('question_1')->nullable();
        $table->string('question_2')->nullable();
        $table->string('question_3')->nullable();
        $table->string('name');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->string('timeline')->nullable();
        $table->text('message')->nullable();
        $table->timestamps();
        
        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_inquiries');
    }
};
