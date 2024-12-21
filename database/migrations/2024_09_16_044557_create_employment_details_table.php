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
        Schema::create('employment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('depertment_id')->nullable();
            $table->string('ddo_code')->nullable();
            $table->unsignedBigInteger('office_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->date('first_date_of_joining')->nullable();
            $table->date('current_date_of_joining')->nullable();
            $table->string('ex_serviceman')->nullable();
            $table->unsignedBigInteger('pay_grade')->nullable();
            $table->string('pay_band')->nullable();
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
        Schema::dropIfExists('employment_details');
    }
};
