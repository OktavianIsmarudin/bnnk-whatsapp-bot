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
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('contact_name')->nullable();
            $table->text('message_in')->nullable();
            $table->text('message_out')->nullable();
            $table->string('message_type')->default('text'); // text, image, document
            $table->json('metadata')->nullable(); // additional data
            $table->timestamp('sent_at')->nullable();
            $table->string('status')->default('pending'); // pending, sent, delivered, failed
            $table->string('whatsapp_message_id')->nullable();
            $table->timestamps();
            
            $table->index('phone_number');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
