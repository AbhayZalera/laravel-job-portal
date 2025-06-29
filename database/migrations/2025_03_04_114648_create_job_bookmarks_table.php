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
        Schema::create('job_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('candidate_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.p
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bookmarks');
    }
};
