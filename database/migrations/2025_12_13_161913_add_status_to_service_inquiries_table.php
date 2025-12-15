<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if status column doesn't exist before adding
        if (!Schema::hasColumn('service_inquiries', 'status')) {
            Schema::table('service_inquiries', function (Blueprint $table) {
                $table->enum('status', ['pending', 'in_progress', 'completed'])
                      ->default('pending')
                      ->after('message');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('service_inquiries', 'status')) {
            Schema::table('service_inquiries', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};