<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('document_number')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_type_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->string('file_name');
            $table->string('original_name');
            $table->string('mime_type');
            $table->integer('file_size');
            $table->enum('confidentiality_level', ['public', 'internal', 'confidential', 'secret'])
                ->default('internal');
            $table->date('document_date');
            $table->json('metadata')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category_id', 'document_type_id']);
            $table->index(['confidentiality_level']);
            $table->index(['document_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
