<div
    x-data="{ online: navigator.onLine }"
    x-init="
        window.addEventListener('online', () => { online = true; });
        window.addEventListener('offline', () => { online = false; });
    "
    x-show="!online"
    x-cloak
    x-transition
    class="fixed top-0 left-0 right-0 z-50 px-4 py-2 text-center text-sm font-medium bg-amber-500 text-amber-950 shadow"
    style="display: none;"
>
    Você está offline. Alterações serão sincronizadas ao reconectar.
</div>
