<!-- PWA Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            // Unregister all existing service workers first
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for(let registration of registrations) {
                    registration.unregister();
                }
                
                // Register new service worker
                return navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });
            }).then(function(registration) {
                console.log('Service Worker registered successfully:', registration.scope);
                
                // Handle updates
                registration.addEventListener('updatefound', function() {
                    const newWorker = registration.installing;
                    newWorker.addEventListener('statechange', function() {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            // New service worker available
                            if (confirm('Update tersedia. Reload untuk mendapatkan versi terbaru?')) {
                                newWorker.postMessage({ type: 'SKIP_WAITING' });
                                window.location.reload();
                            }
                        }
                    });
                });
            }).catch(function(error) {
                console.log('Service Worker registration failed:', error);
            });
        });
    }
    
    // PWA Install Prompt
    let deferredPrompt;
    const installButton = document.getElementById('pwa-install');
    
    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('PWA install prompt triggered');
        e.preventDefault();
        deferredPrompt = e;
        
        // Show install button if not already installed
        if (installButton) {
            installButton.style.display = 'block';
        }
        
        // Show custom notification after a delay
        setTimeout(showInstallNotification, 3000);
    });
    
    function showInstallNotification() {
        // Show Filament notification for PWA install
        if (window.Filament) {
            const notification = window.Filament.notification()
                .title('Install Aplikasi')
                .body('Install Digital Arsip SDN 009 untuk akses yang lebih cepat dan dapat digunakan offline!')
                .actions([
                    {
                        name: 'install',
                        label: 'Install Sekarang',
                        color: 'primary',
                        action: () => {
                            installPWA();
                        }
                    },
                    {
                        name: 'cancel',
                        label: 'Nanti Saja',
                        action: () => {
                            // Store user preference
                            localStorage.setItem('pwa-install-dismissed', Date.now());
                        }
                    }
                ])
                .persistent()
                .send();
        }
    }
    
    // Handle successful installation
    window.addEventListener('appinstalled', (evt) => {
        console.log('PWA was installed successfully');
        
        // Hide install button
        if (installButton) {
            installButton.style.display = 'none';
        }
        
        if (window.Filament) {
            window.Filament.notification()
                .title('Instalasi Berhasil!')
                .body('Digital Arsip SDN 009 telah terinstall di perangkat Anda. Anda dapat mengaksesnya dari home screen.')
                .success()
                .send();
        }
        
        // Clear install prompt
        deferredPrompt = null;
    });
    
    // Check if app is running in standalone mode
    if (window.matchMedia('(display-mode: standalone)').matches) {
        console.log('App is running in standalone mode');
        document.body.classList.add('pwa-standalone');
        
        // Add PWA-specific styles or behaviors
        document.documentElement.style.setProperty('--pwa-safe-area-top', 'env(safe-area-inset-top)');
        document.documentElement.style.setProperty('--pwa-safe-area-bottom', 'env(safe-area-inset-bottom)');
    }
    
    // Handle online/offline status
    function updateOnlineStatus() {
        if (navigator.onLine) {
            document.body.classList.remove('offline');
            if (window.Filament) {
                window.Filament.notification()
                    .title('Online')
                    .body('Koneksi internet tersedia kembali.')
                    .success()
                    .duration(3000)
                    .send();
            }
        } else {
            document.body.classList.add('offline');
            if (window.Filament) {
                window.Filament.notification()
                    .title('Offline')
                    .body('Tidak ada koneksi internet. Beberapa fitur mungkin terbatas.')
                    .warning()
                    .persistent()
                    .send();
            }
        }
    }
    
    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    
    // Initialize online status
    updateOnlineStatus();
    
    </script>
    
    <!-- PWA Install Button -->
    <style>
    #pwa-install {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        display: none;
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        min-width: 120px;
        text-align: center;
    }
    
    #pwa-install:hover {
        background: linear-gradient(135deg, #2563EB, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
    }
    
    #pwa-install:active {
        transform: translateY(0);
    }
    
    .pwa-standalone {
        /* Styles for when app is running in standalone mode */
        padding-top: var(--pwa-safe-area-top, 0);
        padding-bottom: var(--pwa-safe-area-bottom, 0);
    }
    
    .offline {
        /* Styles for offline mode */
    }
    
    .offline .fi-topbar {
        border-bottom: 2px solid #f59e0b;
    }
    
    @media (max-width: 768px) {
        #pwa-install {
            bottom: 15px;
            right: 15px;
            padding: 10px 16px;
            font-size: 13px;
            min-width: 100px;
        }
    }
    </style>
    
    <button id="pwa-install" onclick="installPWA()" title="Install aplikasi di perangkat Anda">
        📱 Install App
    </button>
    
    <script>
    function installPWA() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                    document.getElementById('pwa-install').style.display = 'none';
                } else {
                    console.log('User dismissed the install prompt');
                    // Store dismissal
                    localStorage.setItem('pwa-install-dismissed', Date.now());
                }
                deferredPrompt = null;
            });
        } else {
            // Fallback for browsers that don't support install prompt
            if (window.Filament) {
                window.Filament.notification()
                    .title('Install Manual')
                    .body('Gunakan menu browser Anda untuk menambahkan aplikasi ini ke home screen.')
                    .info()
                    .send();
            }
        }
    }
    
    // Check if user previously dismissed install prompt
    const installDismissed = localStorage.getItem('pwa-install-dismissed');
    if (installDismissed) {
        const dismissTime = parseInt(installDismissed);
        const daysSinceDismiss = (Date.now() - dismissTime) / (1000 * 60 * 60 * 24);
        
        // Show prompt again after 7 days
        if (daysSinceDismiss > 7) {
            localStorage.removeItem('pwa-install-dismissed');
        }
    }
    </script>