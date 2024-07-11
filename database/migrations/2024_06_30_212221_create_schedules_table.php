<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class);
            $table->foreignIdFor(Venue::class);
            $table->foreignIdFor(User::class);
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('status');
            $table->dateTime('redefense_on')->nullable();
            $table->integer('type_of_defense');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
