@php
    $record = $getViewData()['record'];
    $fileExists = $record->file_path && \Storage::exists($record->file_path);
    $fileUrl = $fileExists ? \Storage::url($record->file_path) : null;
@endphp

<div class="space-y-4">
    @if(!$fileExists)
        <div class="flex items-center justify-center p-8 bg-gray-50 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">File tidak ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">File mungkin telah dipindahkan atau dihapus</p>
            </div>
        </div>

    @elseif($record->mime_type === 'application/pdf')
        {{-- PDF Preview --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Preview PDF</h4>
                <div class="flex items-center space-x-2">
                    <button 
                        onclick="toggleFullscreen()"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        Fullscreen
                    </button>
                    <a 
                        href="{{ $fileUrl }}" 
                        target="_blank"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka di Tab Baru
                    </a>
                </div>
            </div>
            <div class="p-4">
                <iframe 
                    id="pdf-viewer"
                    src="{{ $fileUrl }}" 
                    class="w-full h-96 border border-gray-300 dark:border-gray-600 rounded"
                    style="min-height: 600px;"
                >
                    <p>Browser Anda tidak mendukung iframe. <a href="{{ $fileUrl }}" target="_blank">Klik di sini untuk membuka PDF</a></p>
                </iframe>
            </div>
        </div>

        <script>
            function toggleFullscreen() {
                const iframe = document.getElementById('pdf-viewer');
                if (!document.fullscreenElement) {
                    iframe.requestFullscreen().catch(err => {
                        alert('Error attempting to enable fullscreen mode: ' + err.message);
                    });
                } else {
                    document.exitFullscreen();
                }
            }
        </script>

    @elseif(str_starts_with($record->mime_type, 'image/'))
        {{-- Image Preview --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Preview Gambar</h4>
                <a 
                    href="{{ $fileUrl }}" 
                    target="_blank"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Ukuran Penuh
                </a>
            </div>
            <div class="p-4 text-center">
                <img 
                    src="{{ $fileUrl }}" 
                    alt="{{ $record->title }}"
                    class="max-w-full h-auto mx-auto rounded-lg shadow-lg"
                    style="max-height: 500px;"
                >
            </div>
        </div>

    @elseif($record->mime_type === 'text/plain')
        {{-- Text File Preview --}}
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Preview Text</h4>
                <a 
                    href="{{ $fileUrl }}" 
                    target="_blank"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    Download File
                </a>
            </div>
            <div class="p-4">
                <pre class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg text-sm text-gray-900 dark:text-gray-100 overflow-auto max-h-96">{{ \Storage::get($record->file_path) }}</pre>
            </div>
        </div>

    @else
        {{-- Unsupported File Type --}}
        <div class="flex items-center justify-center p-8 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Preview tidak tersedia</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Tipe file {{ $record->mime_type }} tidak dapat di-preview.<br>
                    Silakan download untuk membuka file.
                </p>
                <div class="mt-4">
                    <a 
                        href="{{ $fileUrl }}" 
                        download="{{ $record->original_name }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download {{ $record->original_name }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>