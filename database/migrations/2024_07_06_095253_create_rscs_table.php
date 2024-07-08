<?php

use App\Models\Team;
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
        Schema::create('rscs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class);
            $table->foreignIdFor(User::class);
            $table->integer('status');
            $table->string('manuscript_chapter')->nullable();
            $table->text('manuscript_rsc');
            $table->string('software_program_dfd_number')->nullable();
            $table->text('software_program_rsc');
            $table->text('general_comments')->nullable();
            $table->boolean('redefense_status')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rscs');
    }
};
