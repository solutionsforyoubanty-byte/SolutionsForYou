<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('razorpay_order_id')->nullable()->after('payment_method');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_order_id');
            $table->string('razorpay_signature')->nullable()->after('razorpay_payment_id');
            $table->decimal('discount', 10, 2)->default(0)->after('tax');
            $table->string('coupon_code')->nullable()->after('discount');
            $table->decimal('shipping_charge', 10, 2)->default(0)->after('coupon_code');
            $table->foreignId('address_id')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'discount', 'coupon_code', 'shipping_charge', 'address_id']);
        });
    }
};
