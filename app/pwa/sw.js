self.addEventListener("install", e => {
    e.waitUntil(
        caches.open("static").then(cache => {
            return cache.addAll(["../","./src/master.css",".pwa/new_icon/192.png",".pwa/new_icon/512.png",".pwa/new_icon/120.png",".pwa/new_icon/180.png",".pwa/new_icon/256.png",".pwa/new_icon/1024.png",".pwa/new_icon/72.png"])
        })
    );
});

self.addEventListener('activate', e => {
    console.log("sw activated",e);
})

self.addEventListener("fetch", e => {
    e.respondWith(
        caches.match(e.request).then(response => {
            return response || fetch(e.request);
        })
    );
});

let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        deferredPrompt = e;
    });

    const installApp = document.getElementById('installApp');
    installApp.addEventListener('click', async () => {
        if (deferredPrompt !== null) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            if (outcome === 'accepted') {
                deferredPrompt = null;
            }
        }
    });