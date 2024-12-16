<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dateTime('date_time')->nullable()->after("type");
        });

        DB::table('transactions')->each(function ($item) {
            $dateTime = \Carbon\Carbon::parse($item->date)->toDateTimeString();
            $item->update(['date_time' => $dateTime]);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dateTime('date_time')->after("type")->change();
        });
    }
};
