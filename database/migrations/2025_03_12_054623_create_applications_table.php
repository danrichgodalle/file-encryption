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

            $table->longText(column: 'nick_name')->nullable();
            $table->longText(column: 'address')->nullable();
            $table->longText(column: 'tel_no')->nullable();
            $table->longText(column: 'cell_no')->nullable();
            $table->longText(column: 'length_of_stay')->nullable();
            $table->longText(column: 'ownership')->nullable();
            $table->longText(column: 'rent_amount')->nullable();


            $table->longText(column: 'date_of_birth')->nullable();
            $table->longText(column: 'place_of_birth')->nullable();
            $table->longText(column: 'age')->nullable();
            $table->longText(column: 'civil_status')->nullable();
            $table->longText(column: 'dependents')->nullable();
            $table->longText(column: 'contact_person')->nullable();

            $table->longText(column: 'employment')->nullable();
            $table->longText(column: 'position')->nullable();
            $table->longText(column: 'employer_name')->nullable();
            $table->longText(column: 'employer_address')->nullable();

            $table->longText(column: 'spouse_employment')->nullable();
            $table->longText(column: 'spouse_position')->nullable();
            $table->longText(column: 'spouse_employer_name')->nullable();
            $table->longText(column: 'spouse_employer_address')->nullable();

            $table->longText('properties')->nullable();

            $table->longText(column: 'monthly_income')->nullable();
            $table->string('encryption_key')->nullable();
            
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
