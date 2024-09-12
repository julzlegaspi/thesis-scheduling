<?php

use App\Models\Rsc;
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
        Schema::create('comment_rscs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rsc::class);
            $table->string('chapter')->nullable();
            $table->string('page_number')->nullable();
            $table->text('comments');
            $table->text('action_taken')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_rscs');
    }
};
