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
        Schema::table('verification_remarks_documents', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('this status show is any remarks last approval if 1 then ysed there are remarks in last approval and 2 no remarks ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verification_remarks_documents', function (Blueprint $table) {
            $table->integer('status');
        });
    }
};
