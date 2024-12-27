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
        Schema::table('rejected_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('authority_id')->comment('who rejected user');
            $table->integer('rejection_type')->comment('1 for verification,2 recomandation,3 transfers');
            $table->string('commnents')->nullable()->comment('rejected commnent main commnent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rejected_documents', function (Blueprint $table) {
            $table->dropColumn('commnents');
        });
    }
};
