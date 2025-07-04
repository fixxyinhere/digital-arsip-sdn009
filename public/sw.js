const CACHE_NAME = 'digital-arsip-sdn009-v1.1.0';
const STATIC_CACHE = 'static-v1.1.0';

// Cache hanya untuk asset statis
const STATIC_ASSETS = [
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
    '/offline'
];

// Route yang TIDAK boleh di-cache (untuk Filament)
const DYNAMIC_ROUTES = [
    '/admin',
    '/livewire',
    '/api',
    '/login',
    '/logout',
    '/csrf-token'
];

// Install event - hanya cache asset statis
self.addEventListener('install', function(event) {
    console.log('Service Worker installing');
    self.skipWaiting(); // Force activate immediately
    
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(function(cache) {
                console.log('Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .catch(function(error) {
                console.error('Failed to cache static assets:', error);
            })
    );
});

// Activate event - cleanup old caches
self.addEventListener('activate', function(event) {
    console.log('Service Worker activating');
    
    event.waitUntil(
        Promise.all([
            // Take control immediately
            self.clients.claim(),
            // Clean up old caches
            caches.keys().then(function(cacheNames) {
                return Promise.all(
                    cacheNames.map(function(cacheName) {
                        if (cacheName !== CACHE_NAME && cacheName !== STATIC_CACHE) {
                            console.log('Deleting old cache:', cacheName);
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
        ])
    );
});

// Fetch event - strategy berdasarkan tipe request
self.addEventListener('fetch', function(event) {
    const request = event.request;
    const url = new URL(request.url);
    
    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }
    
    // Skip chrome-extension dan internal requests
    if (url.protocol === 'chrome-extension:' || url.protocol === 'moz-extension:') {
        return;
    }
    
    // Check if request is for dynamic route (admin, livewire, etc)
    const isDynamicRoute = DYNAMIC_ROUTES.some(route => 
        url.pathname.startsWith(route)
    );
    
    // Check if request is for API or has query parameters (dynamic content)
    const isAPIRequest = url.pathname.includes('/livewire/') || 
                        url.searchParams.toString() !== '' ||
                        request.headers.get('X-Livewire') ||
                        request.headers.get('X-Requested-With') === 'XMLHttpRequest';
    
    if (isDynamicRoute || isAPIRequest) {
        // Network-first strategy for dynamic content
        event.respondWith(
            fetch(request)
                .then(function(response) {
                    // Return network response
                    return response;
                })
                .catch(function(error) {
                    console.warn('Network request failed for:', request.url, error);
                    // Fallback to offline page if available
                    return caches.match('/offline').then(function(offlineResponse) {
                        return offlineResponse || new Response('Offline', { 
                            status: 503, 
                            statusText: 'Service Unavailable' 
                        });
                    });
                })
        );
    } else {
        // Cache-first strategy for static assets
        event.respondWith(
            caches.match(request)
                .then(function(cachedResponse) {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    
                    // If not in cache, fetch from network
                    return fetch(request)
                        .then(function(response) {
                            // Cache successful responses for static assets
                            if (response.status === 200) {
                                const responseClone = response.clone();
                                caches.open(STATIC_CACHE)
                                    .then(function(cache) {
                                        cache.put(request, responseClone);
                                    });
                            }
                            return response;
                        });
                })
                .catch(function(error) {
                    console.warn('Cache and network both failed for:', request.url);
                    return caches.match('/offline');
                })
        );
    }
});

// Background sync untuk offline functionality
self.addEventListener('sync', function(event) {
    if (event.tag === 'background-sync') {
        console.log('Background sync triggered');
        // Handle offline data sync here
    }
});

// Push notifications
self.addEventListener('push', function(event) {
    if (!event.data) {
        return;
    }
    
    const options = {
        body: event.data.text(),
        icon: '/images/icons/icon-192x192.png',
        badge: '/images/icons/icon-96x96.png',
        vibrate: [200, 100, 200],
        data: {
            url: '/admin'
        },
        actions: [
            {
                action: 'open',
                title: 'Buka',
                icon: '/images/icons/icon-96x96.png'
            },
            {
                action: 'close',
                title: 'Tutup'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification('Digital Arsip SDN 009', options)
    );
});

// Handle notification clicks
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    if (event.action === 'open' || !event.action) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url || '/admin')
        );
    }
});

// Message handling untuk communication dengan main thread
self.addEventListener('message', function(event) {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data && event.data.type === 'CACHE_URLS') {
        event.waitUntil(
            caches.open(STATIC_CACHE)
                .then(function(cache) {
                    return cache.addAll(event.data.payload);
                })
        );
    }
});