<?php

namespace App\Services;

use App\Models\DocumentAccessLog;
use Illuminate\Support\Facades\Auth;

class DocumentAccessLogger
{
    /**
     * Log document access with detailed information
     */
    public static function log(int $documentId, string $action, ?array $additionalInfo = null): void
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return;
        }

        $request = request();

        try {
            DocumentAccessLog::create([
                'document_id' => $documentId,
                'user_id' => Auth::id(),
                'action' => $action,
                'ip_address' => $request->ip() ?? 'unknown',
                'user_agent' => $request->userAgent(),
                'additional_info' => $additionalInfo,
                'accessed_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log error jika diperlukan, tapi jangan mengganggu proses utama
            \Log::error('Failed to log document access: ' . $e->getMessage());
        }
    }

    public static function logView(int $documentId, ?array $additionalInfo = null): void
    {
        self::log($documentId, 'view', $additionalInfo);
    }

    public static function logDownload(int $documentId, ?array $additionalInfo = null): void
    {
        self::log($documentId, 'download', $additionalInfo);
    }

    public static function logUpload(int $documentId, ?array $additionalInfo = null): void
    {
        self::log($documentId, 'upload', $additionalInfo);
    }

    public static function logUpdate(int $documentId, ?array $additionalInfo = null): void
    {
        self::log($documentId, 'update', $additionalInfo);
    }

    public static function logDelete(int $documentId, ?array $additionalInfo = null): void
    {
        self::log($documentId, 'delete', $additionalInfo);
    }
}
