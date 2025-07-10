<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi Kesalahan - Arsip Digital</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-red-50 via-white to-orange-50">
    <div class="min-h-full flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Error Icon -->
        <div class="text-center mb-8">
            <div class="mx-auto h-20 w-20 bg-gradient-to-r from-red-500 to-orange-600 rounded-full flex items-center justify-center shadow-lg animate-shake">
                <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-md w-full space-y-8 text-center">
            <!-- Status Code -->
            <div>
                <h1 class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-600">
                    500
                </h1>
            </div>

            <!-- Title -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Oops! Terjadi Kesalahan
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    Maaf, terjadi kesalahan internal pada server. Tim teknis kami sedang menangani masalah ini.
                </p>
            </div>

            <!-- Error Info -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900">Status</p>
                            <p class="text-sm text-red-600">Server Error Internal</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900">Waktu Kejadian</p>
                            <p class="text-sm text-gray-500" id="error-time">{{ date('d M Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900">Tim Teknis</p>
                            <p class="text-sm text-gray-500">Sudah diberitahu otomatis</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Apa yang bisa Anda lakukan?</h3>
                <div class="space-y-3 text-left">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-semibold text-blue-600">1</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Tunggu beberapa menit dan coba refresh halaman</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-semibold text-blue-600">2</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Kembali ke halaman sebelumnya</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 mt-0.5">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-xs font-semibold text-blue-600">3</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">Hubungi administrator jika masalah berlanjut</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button 
                    onclick="location.reload()" 
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg"
                >
                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Coba Lagi
                </button>
                
                <button 
                    onclick="history.back()" 
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-200"
                >
                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </button>
                
                <div class="text-center">
                    <span class="text-sm text-gray-500">
                        Butuh bantuan? 
                        <a href="mailto:admin@sekolah.id" class="text-blue-600 hover:text-blue-700 font-medium">
                            Hubungi Administrator
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400">
                Error ID: {{ Str::random(8) }} | © {{ date('Y') }} Sistem Arsip Digital
            </p>
        </div>
    </div>
</body>
</html>