<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('slug');
            $table->string('brand')->nullable()->after('sku');
            $table->json('images')->nullable()->after('image');
            $table->json('specifications')->nullable()->after('description');
            $table->decimal('avg_rating', 2, 1)->default(0)->after('is_featured');
            $table->integer('reviews_count')->default(0)->after('avg_rating');
            $table->integer('sold_count')->default(0)->after('reviews_count');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'brand', 'images', 'specifications', 'avg_rating', 'reviews_count', 'sold_count']);
        });
    }
};
