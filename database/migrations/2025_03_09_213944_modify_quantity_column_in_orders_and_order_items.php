<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement('ALTER TABLE orders MODIFY quantity INT');
        DB::statement('ALTER TABLE order_items MODIFY quantity INT');
    }

    public function down()
    {
        DB::statement('ALTER TABLE orders MODIFY quantity VARCHAR(255)');
        DB::statement('ALTER TABLE order_items MODIFY quantity VARCHAR(255)');
    }
};
