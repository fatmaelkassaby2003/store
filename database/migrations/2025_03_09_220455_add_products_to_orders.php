<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل التعديلات على الجدول
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('products')->nullable(); // إضافة عمود المنتجات
        });
    }

    /**
     * التراجع عن التعديلات
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('products'); // حذف العمود إذا لزم الأمر
        });
    }
};
