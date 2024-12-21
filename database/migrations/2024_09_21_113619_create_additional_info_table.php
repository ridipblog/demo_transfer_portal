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
        Schema::create('additional_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('criminal_case')->nullable()->comment('Are there any criminal cases pending?');
            $table->string('departmental_proceedings')->nullable()->comment('Are there any departmental proceedings pending against you??');
            $table->string('mutual_transfer')->nullable()->comment('Have you availed any mutual transfer before?');
            $table->integer('no_mutual_transfer')->nullable()->nullable()->comment('How many mutual transfer?');
            $table->string('pending_govt_dues')->nullable()->comment('Any pending govt. dues');
            $table->foreign('user_id')
                ->references('id')
                ->on('user_credentials')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_info');
    }
};
