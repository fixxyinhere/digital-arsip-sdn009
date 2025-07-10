<?php

namespace App\Observers;

use App\Models\Document;
use App\Services\DocumentAccessLogger;

class DocumentObserver
{
    /**
     * Handle the Document "created" event.
     * Dipanggil ketika dokumen baru dibuat/diupload
     */
    public function created(Document $document): void
    {
        DocumentAccessLogger::logUpload($document->id, [
            'document_title' => $document->title,
            'document_number' => $document->document_number,
            'file_name' => $document->original_name,
            'file_size' => $document->file_size,
            'category' => $document->category?->name,
            'document_type' => $document->documentType?->name,
            'confidentiality_level' => $document->confidentiality_level,
        ]);
    }

    /**
     * Handle the Document "updated" event.
     * Dipanggil ketika dokumen diupdate
     */
    public function updated(Document $document): void
    {
        // Hanya log jika ada perubahan yang signifikan
        $changedFields = array_keys($document->getDirty());

        // Filter field yang tidak perlu di-log
        $ignoredFields = ['updated_at', 'updated_by'];
        $significantChanges = array_diff($changedFields, $ignoredFields);

        if (!empty($significantChanges)) {
            DocumentAccessLogger::logUpdate($document->id, [
                'document_title' => $document->title,
                'document_number' => $document->document_number,
                'changed_fields' => $significantChanges,
                'old_values' => $document->getOriginal(),
                'new_values' => $document->getAttributes(),
            ]);
        }
    }

    /**
     * Handle the Document "deleting" event.
     * Dipanggil sebelum dokumen dihapus (saat masih ada data)
     */
    public function deleting(Document $document): void
    {
        DocumentAccessLogger::logDelete($document->id, [
            'document_title' => $document->title,
            'document_number' => $document->document_number,
            'file_name' => $document->original_name,
            'category' => $document->category?->name,
            'document_type' => $document->documentType?->name,
        ]);
    }
}
