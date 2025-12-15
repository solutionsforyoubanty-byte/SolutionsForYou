<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('client_name')->nullable();
            $table->string('project_url')->nullable();
            $table->string('technologies')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
