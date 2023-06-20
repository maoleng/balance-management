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
        Schema::create('notify_coins', function (Blueprint $table) {
            $table->id();
            $table->string('coin', 10);
            $table->double('coin_amount');
            $table->double('balance');
            $table->boolean('is_notify');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify_coins');
    }
};
