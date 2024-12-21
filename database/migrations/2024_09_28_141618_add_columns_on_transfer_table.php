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
        Schema::table('transafers', function (Blueprint $table) {
            $table->string('transfer_ref_code')->unique()->nullable()->after('remarks');
            $table->integer('final_approval')->default(0)->comment('0 not process or not approved by target employee','1 approved by approver','2 rejected by approver')->after('transfer_ref_code');
            $table->string('approver_remarks')->nullable()->comment('approver remarks after action on mutual request ')->after('final_approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transafers', function (Blueprint $table) {
            $table->dropColumn('transfer_ref_code');
            $table->dropColumn('final_approval');
            $table->dropColumn('approver_remarks');
        });
    }
};
