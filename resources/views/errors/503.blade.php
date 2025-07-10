<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Sedang Maintenance - Arsip Digital</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="min-h-full flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="animate-float">
                <div class="mx-auto h-20 w-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-md w-full space-y-8 text-center">
            <!-- Status Code -->
            <div>
                <h1 class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                    503
                </h1>
            </div>

            <!-- Title -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Sistem Sedang Maintenance
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    Mohon maaf, sistem arsip digital sedang dalam tahap pemeliharaan untuk memberikan pelayanan yang lebih baik.
                </p>
            </div>

            <!-- Features/Info -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900">Estimasi Waktu</p>
                            <p class="text-sm text-gray-500">5-15 menit</p>
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
                            <p class="text-sm font-medium text-gray-900">Data Aman</p>
                            <p class="text-sm text-gray-500">Semua data dokumen terlindungi</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-900">Peningkatan Performa</p>
                            <p class="text-sm text-gray-500">Sistem akan lebih cepat</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress Maintenance</span>
                        <span class="text-sm text-gray-500" id="progress-text">75%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full animate-pulse-slow" style="width: 75%" id="progress-bar"></div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 text-center">
                    Halaman akan refresh otomatis setiap 30 detik
                </p>
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
                    Refresh Halaman
                </button>
                
                <div class="text-center">
                    <span class="text-sm text-gray-500">
                        Butuh bantuan? Hubungi 
                        <a href="mailto:admin@sekolah.id" class="text-blue-600 hover:text-blue-700 font-medium">
                            admin@sekolah.id
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Sistem Arsip Digital. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>

    <!-- Auto Refresh Script -->
    <script>
        // Auto refresh setiap 30 detik
        setTimeout(function() {
            location.reload();
        }, 30000);

        // Animate progress bar
        let progress = 75;
        setInterval(function() {
            progress += Math.random() * 5;
            if (progress > 95) progress = 75;
            
            document.getElementById('progress-bar').style.width = progress + '%';
            document.getElementById('progress-text').textContent = Math.round(progress) + '%';
        }, 2000);

        // Show current time
        function updateTime() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID');
            console.log('Current time:', time);
        }
        setInterval(updateTime, 1000);
    </script>
</body>
</html>