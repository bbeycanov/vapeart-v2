/**
 * VapeArt Baku - Service Worker
 * PWA offline support and caching strategy
 */

const CACHE_NAME = 'vapeart-cache-v3';
const OFFLINE_URL = '/offline.html';

// Assets to cache immediately on install
const PRECACHE_ASSETS = [
    '/',
    '/offline.html',
    '/storefront/css/style.css',
    '/storefront/js/theme.js',
    '/storefront/images/favicon.ico',
    '/storefront/images/favicon.png',
    '/storefront/images/icons/icon-192x192.png',
    '/manifest.json'
];

// Install event - cache essential assets (fault-tolerant)
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                // Cache each asset individually to prevent one failure from breaking all
                return Promise.all(
                    PRECACHE_ASSETS.map((url) => {
                        return cache.add(url).catch((err) => {
                            // Log but don't fail if a single asset fails
                            console.warn('Failed to cache:', url, err);
                        });
                    })
                );
            })
            .then(() => {
                return self.skipWaiting();
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((cacheName) => cacheName !== CACHE_NAME)
                        .map((cacheName) => {
                            return caches.delete(cacheName);
                        })
                );
            })
            .then(() => {
                return self.clients.claim();
            })
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') {
        return;
    }

    // Skip non-http(s) requests (chrome-extension, etc.)
    const url = new URL(event.request.url);
    if (!url.protocol.startsWith('http')) {
        return;
    }

    // Skip admin and API requests
    if (url.pathname.startsWith('/admin') ||
        url.pathname.startsWith('/api') ||
        url.pathname.startsWith('/livewire')) {
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then((cachedResponse) => {
                if (cachedResponse) {
                    // Return cached response and update cache in background
                    event.waitUntil(updateCache(event.request));
                    return cachedResponse;
                }

                // Not in cache, fetch from network
                return fetch(event.request)
                    .then((response) => {
                        // Don't cache if not a valid response
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Cache static assets
                        if (shouldCache(event.request)) {
                            const responseToCache = response.clone();
                            caches.open(CACHE_NAME)
                                .then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                        }

                        return response;
                    })
                    .catch(() => {
                        // Network failed, return offline page for navigation requests
                        if (event.request.mode === 'navigate') {
                            return caches.match(OFFLINE_URL);
                        }
                        return new Response('Offline', { status: 503, statusText: 'Service Unavailable' });
                    });
            })
    );
});

// Helper function to determine if request should be cached
function shouldCache(request) {
    const url = new URL(request.url);
    const pathname = url.pathname;

    // Cache static assets
    if (pathname.match(/\.(css|js|png|jpg|jpeg|gif|svg|webp|woff|woff2|ttf|eot)$/)) {
        return true;
    }

    // Cache storefront assets
    if (pathname.startsWith('/storefront/')) {
        return true;
    }

    return false;
}

// Update cache in background (stale-while-revalidate)
async function updateCache(request) {
    try {
        const response = await fetch(request);
        if (response && response.status === 200) {
            const cache = await caches.open(CACHE_NAME);
            await cache.put(request, response);
        }
    } catch (error) {
        // Background update failed silently
    }
}

// Handle push notifications (future implementation)
self.addEventListener('push', (event) => {
    if (event.data) {
        const data = event.data.json();
        const options = {
            body: data.body,
            icon: '/storefront/images/icons/icon-192x192.png',
            badge: '/storefront/images/icons/icon-72x72.png',
            vibrate: [100, 50, 100],
            data: {
                url: data.url || '/'
            }
        };

        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification.data.url;

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then((clientList) => {
                // Focus existing window if available
                for (const client of clientList) {
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }
                // Open new window
                if (clients.openWindow) {
                    return clients.openWindow(url);
                }
            })
    );
});
