<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('name');
            $table->string('thesis_title');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('member_team', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->constrained();
        });

        Schema::create('panelist_team', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('team_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('member_team');
        Schema::dropIfExists('panelist_team');
        Schema::dropIfExists('approval_status');
    }
};
