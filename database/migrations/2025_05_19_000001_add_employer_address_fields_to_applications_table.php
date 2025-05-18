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
        Schema::table('applications', function (Blueprint $table) {
            $table->longText('employer_city')->nullable()->after('employer_address');
            $table->longText('employer_state')->nullable()->after('employer_city');
            $table->longText('employer_zip_code')->nullable()->after('employer_state');
            $table->longText('spouse_employer_city')->nullable()->after('spouse_employer_address');
            $table->longText('spouse_employer_state')->nullable()->after('spouse_employer_city');
            $table->longText('spouse_employer_zip_code')->nullable()->after('spouse_employer_state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'employer_city',
                'employer_state',
                'employer_zip_code',
                'spouse_employer_city',
                'spouse_employer_state',
                'spouse_employer_zip_code'
            ]);
        });
    }
}; 