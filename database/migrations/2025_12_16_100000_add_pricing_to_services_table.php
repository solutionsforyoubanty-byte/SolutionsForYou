<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('basic_price', 10, 2)->nullable()->after('meta_keywords');
            $table->decimal('standard_price', 10, 2)->nullable()->after('basic_price');
            $table->decimal('premium_price', 10, 2)->nullable()->after('standard_price');
            $table->text('basic_features')->nullable()->after('premium_price');
            $table->text('standard_features')->nullable()->after('basic_features');
            $table->text('premium_features')->nullable()->after('standard_features');
            $table->string('basic_delivery')->nullable()->after('premium_features');
            $table->string('standard_delivery')->nullable()->after('basic_delivery');
            $table->string('premium_delivery')->nullable()->after('standard_delivery');
            $table->boolean('show_pricing')->default(true)->after('premium_delivery');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'basic_price', 'standard_price', 'premium_price',
                'basic_features', 'standard_features', 'premium_features',
                'basic_delivery', 'standard_delivery', 'premium_delivery',
                'show_pricing'
            ]);
        });
    }
};
