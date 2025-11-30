<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_history', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('context')->nullable(); // hero, about, portfolio, etc.
            $table->string('uploaded_by')->nullable();
            $table->integer('usage_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
            
            $table->index('context');
            $table->index('last_used_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_history');
    }
};
