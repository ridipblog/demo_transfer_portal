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
        Schema::table('appointing_authorities', function (Blueprint $table) {
            $table->integer('first_login')->default(0)->after('district')->comment('0 = password not set, 1 = password set');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointing_authorities', function (Blueprint $table) {
            $table->dropColumn('first_login');
        });
    }
};
