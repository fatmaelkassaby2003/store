<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash','visa'])->default('cash')->after('total_price');
            $table->enum('payment_status', ['pending','paid','failed'])->default('pending')->after('payment_method');
            $table->text('order_notes')->nullable()->after('payment_status'); // لو عايز تحفظ ملاحظات العميل
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'order_notes']);
        });
    }
};
