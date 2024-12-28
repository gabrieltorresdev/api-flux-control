<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('transactions_categories', 'categories');

        Schema::table('categories', function (Blueprint $table) {
            $table->string('icon', 10)->comment('emoji unicode')->nullable()->after('is_default');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['icon', 'is_default']);
        });

        Schema::rename('categories', 'transactions_categories');
    }
};
