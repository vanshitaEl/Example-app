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
      

    Schema::table('patients', function (Blueprint $table) {
        $table->unsignedBigInteger('doctor_id'); // New foreign key column
        $table->foreign('doctor_id')->references('id')->on('doctors');
    });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
        Schema::table('patients', function (Blueprint $table) {
            Schema::dropIfExists('doctor_id');
        });
    }
};
