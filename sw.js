const CACHE_NAME = 'cache-v1';
var urlsToCache = [
  'public/webfonts/fa-solid-900.woff2',
  'public/css/all.min.css',
  'public/css/main.css',
  'public/js/jquery-3.4.1.min.js',
  'public/js/all.min.js',
  'public/js/material.js',
  'public/js/main.js',
  'public/offline.html'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(keyList.map((key) => {
        if (key !== CACHE_NAME) {
          return caches.delete(key);
        }
      }));
    })
  );
});

self.addEventListener('fetch', function(event) {
  if(event.request.mode === 'navigate') {
    event.respondWith(fetch(event.request).catch(() => {
      return caches.open(CACHE_NAME).then((cache) => {
        return cache.match('public/offline.html');
      });
    }));
  }
});
