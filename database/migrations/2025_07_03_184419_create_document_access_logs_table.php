<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('action', ['view', 'download', 'upload', 'update', 'delete']);
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->json('additional_info')->nullable();
            $table->timestamp('accessed_at');

            $table->index(['document_id', 'user_id']);
            $table->index(['action']);
            $table->index(['accessed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_access_logs');
    }
};
