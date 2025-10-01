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
        Schema::create('bnnk_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('contact_info');
            $table->string('schedule');
            $table->text('requirements')->nullable();
            $table->json('keywords')->nullable(); // for bot triggers
            $table->string('icon')->nullable(); // emoji or icon for display
            $table->integer('order_priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bnnk_services');
    }
};
