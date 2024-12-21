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
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->integer('verified_remarks_status')->default(0)->after('noc_generated_by')->comment('0 for no objections, 1 for objection');
            $table->integer('noc_remarks_status')->default(0)->after('verified_remarks_status')->comment('0 for no objections, 1 for objection');

            $table->string('verified_remarks')->after('noc_remarks_status')->nullable();
            $table->string('noc_remarks')->after('verified_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_credentials', function (Blueprint $table) {
            $table->dropColumn('verified_remarks_status');
            $table->dropColumn('noc_remarks_status');
            $table->dropColumn('verified_remarks');
            $table->dropColumn('noc_remarks');
        });
    }
};
