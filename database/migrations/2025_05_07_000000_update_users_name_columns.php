<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            
            // Copy existing name data to first_name
            // DB::statement('UPDATE users SET first_name = name');
            
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            
            // Combine first and last name back to name
            DB::statement('UPDATE users SET name = CONCAT(first_name, " ", last_name)');
            
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
}; 