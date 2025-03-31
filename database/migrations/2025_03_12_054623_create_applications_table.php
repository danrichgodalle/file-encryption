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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->longText(column: 'name');
            $table->longText(column: 'date_of_birth')->nullable();
            $table->longText(column: 'age')->nullable();
            $table->longText(column: 'civil_status')->nullable();
            $table->longText(column: 'spouse')->nullable();
            $table->longText(column: 'contact_person')->nullable();
            $table->longText(column: 'source_of_Income')->nullable();
            $table->longText(column: 'monthly_income')->nullable();
            $table->longText('personal_properties')->nullable();
            $table->string(column: 'status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
