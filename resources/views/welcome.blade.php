<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAD - Sistem Arsip Digital SDN 009 Tanjung Medan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=poppins:300,400,500,600,700,800" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            
            --bg-light: #ffffff;
            --bg-light-secondary: #f8fafc;
            --bg-light-tertiary: #f1f5f9;
            --text-light: #1e293b;
            --text-light-secondary: #64748b;
            
            --bg-dark: #0f172a;
            --bg-dark-secondary: #1e293b;
            --bg-dark-tertiary: #334155;
            --text-dark: #f8fafc;
            --text-dark-secondary: #cbd5e1;
            
            --border-light: #e2e8f0;
            --border-dark: #334155;
            
            --shadow-light: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-medium: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-large: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        .light-mode {
            background: linear-gradient(135deg, var(--bg-light) 0%, var(--bg-light-secondary) 100%);
            color: var(--text-light);
        }

        .dark-mode {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-dark-secondary) 100%);
            color: var(--text-dark);
        }

        /* Animated background elements */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        .floating-shape:nth-child(1) {
            top: 20%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            top: 60%;
            right: 15%;
            width: 120px;
            height: 120px;
            background: var(--secondary);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation-delay: 5s;
        }

        .floating-shape:nth-child(3) {
            bottom: 30%;
            left: 20%;
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 20px;
            animation-delay: 10s;
            transform: rotate(45deg);
        }

        .floating-shape:nth-child(4) {
            top: 10%;
            right: 30%;
            width: 100px;
            height: 100px;
            background: var(--success);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            animation-delay: 15s;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
            100% { transform: translateY(0) rotate(360deg); }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 2rem;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid;
            transition: all 0.3s ease;
        }

        .light-mode .header {
            background: rgba(255, 255, 255, 0.8);
            border-color: var(--border-light);
        }

        .dark-mode .header {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--border-dark);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 18px;
            box-shadow: var(--shadow-medium);
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-link {
            padding: 8px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .light-mode .nav-link {
            color: var(--text-light);
        }

        .dark-mode .nav-link {
            color: var(--text-dark);
        }

        .nav-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .nav-link.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .nav-link.primary:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: var(--shadow-large);
        }

        /* Theme Toggle */
        .theme-toggle {
            background: none;
            border: 2px solid;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin-left: 1rem;
        }

        .light-mode .theme-toggle {
            border-color: var(--border-light);
            color: var(--text-light);
        }

        .dark-mode .theme-toggle {
            border-color: var(--border-dark);
            color: var(--text-dark);
        }

        .theme-toggle:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: scale(1.1) rotate(15deg);
        }

        /* Main Content */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6rem 2rem 2rem;
        }

        .hero-section {
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content {
            animation: slideInLeft 1s ease-out;
        }

        .hero-visual {
            animation: slideInRight 1s ease-out;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .light-mode .hero-subtitle {
            color: var(--text-light);
        }

        .dark-mode .hero-subtitle {
            color: var(--text-dark);
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .light-mode .hero-description {
            color: var(--text-light-secondary);
        }

        .dark-mode .hero-description {
            color: var(--text-dark-secondary);
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cta-button {
            padding: 14px 28px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 2px solid transparent;
        }

        .cta-button.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: var(--shadow-medium);
        }

        .cta-button.primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .cta-button.secondary {
            border-color: var(--primary);
            color: var(--primary);
        }

        .cta-button.secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-large);
        }

        /* Hero Visual */
        .hero-visual-container {
            position: relative;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .document-stack {
            position: relative;
            transform-style: preserve-3d;
        }

        .document {
            width: 280px;
            height: 360px;
            border-radius: 20px;
            position: absolute;
            box-shadow: var(--shadow-xl);
            transition: all 0.5s ease;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .light-mode .document {
            background: white;
            border: 1px solid var(--border-light);
        }

        .dark-mode .document {
            background: var(--bg-dark-secondary);
            border: 1px solid var(--border-dark);
        }

        .document:nth-child(1) {
            transform: translateZ(0) rotate(-5deg);
            z-index: 3;
        }

        .document:nth-child(2) {
            transform: translateZ(-20px) rotate(0deg) translateX(40px);
            z-index: 2;
        }

        .document:nth-child(3) {
            transform: translateZ(-40px) rotate(5deg) translateX(80px);
            z-index: 1;
        }

        .document:hover {
            transform: translateZ(20px) rotate(0deg) scale(1.05);
            z-index: 10;
        }

        .document-header {
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .document-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .document-line {
            height: 8px;
            border-radius: 4px;
            opacity: 0.7;
        }

        .document-line.full {
            width: 100%;
        }

        .document-line.half {
            width: 60%;
        }

        .document-line.quarter {
            width: 40%;
        }

        .light-mode .document-line {
            background: var(--bg-light-tertiary);
        }

        .dark-mode .document-line {
            background: var(--bg-dark-tertiary);
        }

        /* Features Section */
        .features {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            margin-top: 6rem;
            padding: 4rem 2rem;
            border-radius: 30px;
            position: relative;
            overflow: hidden;
        }

        .features::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .features-title {
            text-align: center;
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero-section {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-visual-container {
                height: 400px;
            }

            .document {
                width: 200px;
                height: 280px;
            }

            .document:nth-child(2) {
                transform: translateZ(-20px) rotate(0deg) translateX(30px);
            }

            .document:nth-child(3) {
                transform: translateZ(-40px) rotate(5deg) translateX(60px);
            }

            .features-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="light-mode" id="body">
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <nav class="nav-container">
            <div class="logo-container">
                <div class="logo">S</div>
                <span class="logo-text">SIAD</span>
            </div>
            
            <div class="nav-links">
                <a href="/admin" class="nav-link primary">Masuk</a>
            </div>
            
            <button class="theme-toggle" onclick="toggleTheme()">
                <span id="theme-icon">🌙</span>
            </button>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">SIAD</h1>
                <h2 class="hero-subtitle">Sistem Informasi Arsip Digital</h2>
                <p class="hero-description">
                    Platform digital modern untuk mengelola arsip dokumen SDN 009 Tanjung Medan. 
                    Simpan, kelola, dan akses dokumen penting dengan mudah, aman, dan efisien.
                </p>
                
                <div class="cta-buttons">
                    <a href="/admin" class="cta-button primary">
                        🚀 Mulai Sekarang
                    </a>
                    <a href="#features" class="cta-button secondary">
                        📖 Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-visual-container">
                    <div class="document-stack">
                        <div class="document">
                            <div class="document-header">📄 Dokumen Siswa</div>
                            <div class="document-content">
                                <div class="document-line full"></div>
                                <div class="document-line half"></div>
                                <div class="document-line full"></div>
                                <div class="document-line quarter"></div>
                                <div class="document-line full"></div>
                                <div class="document-line half"></div>
                            </div>
                        </div>
                        
                        <div class="document">
                            <div class="document-header">📋 Laporan Guru</div>
                            <div class="document-content">
                                <div class="document-line full"></div>
                                <div class="document-line quarter"></div>
                                <div class="document-line full"></div>
                                <div class="document-line half"></div>
                                <div class="document-line full"></div>
                                <div class="document-line quarter"></div>
                            </div>
                        </div>
                        
                        <div class="document">
                            <div class="document-header">📊 Data Sekolah</div>
                            <div class="document-content">
                                <div class="document-line half"></div>
                                <div class="document-line full"></div>
                                <div class="document-line quarter"></div>
                                <div class="document-line full"></div>
                                <div class="document-line half"></div>
                                <div class="document-line full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2 class="features-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3 class="feature-title">Manajemen Peran</h3>
                    <p class="feature-description">
                        Sistem kontrol akses berbasis peran untuk mengatur hak akses pengguna sesuai dengan jabatan dan tanggung jawab masing-masing.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Akses Cepat</h3>
                    <p class="feature-description">
                        Temukan dan akses dokumen dalam hitungan detik dengan sistem pencarian yang canggih dan kategorisasi yang rapi.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📋</div>
                    <h3 class="feature-title">Log Aktivitas</h3>
                    <p class="feature-description">
                        Pantau semua aktivitas pengguna dengan sistem log yang lengkap untuk audit dan keamanan data sekolah.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 class="feature-title">Antarmuka Responsif</h3>
                    <p class="feature-description">
                        Antarmuka yang responsif dan mudah digunakan, dapat diakses dengan mudah di komputer, tablet, atau ponsel.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3 class="feature-title">Sinkronisasi Waktu Nyata</h3>
                    <p class="feature-description">
                        Perubahan dokumen tersinkronisasi secara waktu nyata di semua perangkat yang terhubung ke sistem.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3 class="feature-title">Analitik & Laporan</h3>
                    <p class="feature-description">
                        Dashboard analitik untuk memantau penggunaan sistem dan menghasilkan laporan otomatis sesuai kebutuhan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const body = document.getElementById('body');
            const themeIcon = document.getElementById('theme-icon');
            
            if (body.classList.contains('light-mode')) {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                themeIcon.textContent = '☀️';
                localStorage.setItem('theme', 'dark');
            } else {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                themeIcon.textContent = '🌙';
                localStorage.setItem('theme', 'light');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const body = document.getElementById('body');
            const themeIcon = document.getElementById('theme-icon');
            
            if (savedTheme === 'dark') {
                body.classList.remove('light-mode');
                body.classList.add('dark-mode');
                themeIcon.textContent = '☀️';
            } else {
                body.classList.remove('dark-mode');
                body.classList.add('light-mode');
                themeIcon.textContent = '🌙';
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(15, 23, 42, 0.95)';
            } else {
                header.style.background = document.getElementById('body').classList.contains('dark-mode') 
                    ? 'rgba(15, 23, 42, 0.8)' 
                    : 'rgba(255, 255, 255, 0.8)';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });

        // Add parallax effect to floating shapes
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.floating-shape');
            
            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.5;
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    </script>
</body>
</html>