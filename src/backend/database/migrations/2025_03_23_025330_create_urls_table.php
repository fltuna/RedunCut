<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained("users", "id");
            $table->string('original_url');
            $table->string('short_code')->unique();
            $table->timestamp('expires_at')->nullable();
            $table->integer('clicks')->default(0);
            $table->timestamps();
            $table->softDeletes();  // Logical delete

            $table->index('short_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
