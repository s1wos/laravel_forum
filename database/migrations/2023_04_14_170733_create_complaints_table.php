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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->boolean('is_solved')->default(false);
            $table->foreignId('user_id')->index()->constrained('users');
            $table->foreignId('message_id')->index()->constrained('messages');
            $table->foreignId('theme_id')->index()->constrained('themes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
