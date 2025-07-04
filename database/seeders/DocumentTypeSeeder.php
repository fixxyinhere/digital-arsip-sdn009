<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $documentTypes = [
            [
                'name' => 'Dokumen PDF',
                'allowed_extensions' => ['pdf'],
                'max_file_size_mb' => 10,
                'description' => 'File dalam format PDF',
            ],
            [
                'name' => 'Dokumen Word',
                'allowed_extensions' => ['doc', 'docx'],
                'max_file_size_mb' => 15,
                'description' => 'File Microsoft Word',
            ],
            [
                'name' => 'Dokumen Excel',
                'allowed_extensions' => ['xls', 'xlsx'],
                'max_file_size_mb' => 20,
                'description' => 'File Microsoft Excel',
            ],
            [
                'name' => 'Gambar',
                'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'max_file_size_mb' => 5,
                'description' => 'File gambar',
            ],
            [
                'name' => 'Dokumen Umum',
                'allowed_extensions' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'],
                'max_file_size_mb' => 25,
                'description' => 'Berbagai format dokumen umum',
            ],
        ];

        foreach ($documentTypes as $documentType) {
            DocumentType::create($documentType);
        }
    }
}
