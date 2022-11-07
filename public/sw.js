const CACHE_NAME = '001-SW';
const toCache =[
    '/',
    'manifest.json',
    'index.js',
    'icons/icons8-done-192(-hdpi).png'
];


// self.addEventListener("install", e => {
//     console.log("install");
// })

self.addEventListener("install", function(event){
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache){
            return cache.addAll(toCache)
        }).then(self.skipWaiting())
    )
})

self.addEventListener("fetch", function(event){
    event.respondWith(
        fetch(event.request).catch(()=>{
            return caches.open(CACHE_NAME).then((cache)=>{
                return cache.match(event.request)
            })
        })
    )
})

self.addEventListener("activate", function(event){
    event.waitUntil(
        caches.keys().then((keyList)=>{
            return Promise.all(keyList.map((key)=>{
                if(key!== CACHE_NAME){
                    console.log("[Service Worker] Hapus Cache Lama", key)
                    return caches.delete(key)
                }
            }))
        }).then(()=> self.clients.claim())
    )
})