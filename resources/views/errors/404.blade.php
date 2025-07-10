<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - Arsip Digital</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-purple-50 via-white to-pink-50">
    <div class="min-h-full flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Floating Icon -->
        <div class="text-center mb-8">
            <div class="animate-float">
                <div class="mx-auto h-24 w-24 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-lg w-full space-y-8 text-center">
            <!-- Status Code -->
            <div>
                <h1 class="text-8xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                    404
                </h1>
            </div>

            <!-- Title -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Halaman Tidak Ditemukan
                </h2>
                <p class="text-lg text-gray-600 mb-8">
                    Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau URL yang Anda masukkan salah.
                </p>
            </div>

            <!-- Search Suggestions -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Mungkin Anda mencari:</h3>
                <div class="space-y-3">
                    <a href="/admin" class="block w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dashboard Admin</p>
                                <p class="text-xs text-gray-500">Halaman utama sistem</p>
                            </div>
                        </div>
                    </a>

                    <a href="/admin/documents" class="block w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Kelola Dokumen</p>
                                <p class="text-xs text-gray-500">Daftar semua dokumen</p>
                            </div>
                        </div>
                    </a>

                    <a href="/admin/categories" class="block w-full text-left p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Kategori</p>
                                <p class="text-xs text-gray-500">Kelola kategori dokumen</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- URL Info -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-left">
                        <p class="text-sm font-medium text-amber-800">URL yang Anda akses:</p>
                        <p class="text-sm text-amber-700 font-mono break-all">{{ request()->url() }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a 
                    href="/admin" 
                    class="w-full inline-block bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-lg"
                >
                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Kembali ke Dashboard
                </a>
                
                <button 
                    onclick="history.back()" 
                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-200"
                >
                    <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Halaman Sebelumnya
                </button>
                
                <div class="text-center">
                    <span class="text-sm text-gray-500">
                        Masih butuh bantuan? 
                        <a href="mailto:admin@sekolah.id" class="text-purple-600 hover:text-purple-700 font-medium">
                            Hubungi Administrator
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

    <!-- Add some interactive elements -->
    <script>
        // Add click animation to buttons
        document.querySelectorAll('button, a').forEach(element => {
            element.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Easter egg: Konami code
        let konamiCode = [];
        const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // ↑↑↓↓←→←→BA
        
        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            if (konamiCode.length > konamiSequence.length) {
                konamiCode.shift();
            }
            
            if (JSON.stringify(konamiCode) === JSON.stringify(konamiSequence)) {
                document.body.style.background = 'linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #ffeaa7, #dda0dd)';
                document.body.style.backgroundSize = '400% 400%';
                document.body.style.animation = 'gradient 3s ease infinite';
                
                // Add CSS animation
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes gradient {
                        0% { background-position: 0% 50%; }
                        50% { background-position: 100% 50%; }
                        100% { background-position: 0% 50%; }
                    }
                `;
                document.head.appendChild(style);
                
                setTimeout(() => {
                    location.reload();
                }, 5000);
            }
        });
    </script>
</body>
</html>