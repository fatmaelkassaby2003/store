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
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('price'); // حذف عمود السعر
        });
    }

    /**
     * التراجع عن التعديلات
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable(); // إعادة العمود إذا لزم الأمر
        });
    }
};
