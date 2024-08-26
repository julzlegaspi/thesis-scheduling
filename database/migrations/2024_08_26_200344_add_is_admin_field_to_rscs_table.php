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
        Schema::table('rscs', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->string('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rscs', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->dropColumn('file_name');
        });
    }
};
