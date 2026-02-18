@php
    $defaultMessage = '';
    $defaultType = 'success';
@endphp
<div
    x-data="{
        message: @js($defaultMessage),
        type: @js($defaultType),
        show: false,
        timeout: null,
        init() {
            window.addEventListener('toast', (e) => {
                this.message = e.detail?.message ?? 'Ok';
                this.type = e.detail?.type ?? 'success';
                this.show = true;
                if (this.timeout) clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    this.show = false;
                    this.timeout = null;
                }, 4000);
            });
            window.addEventListener('stop-loading', () => {});
        }
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-4 right-4 z-[9998] max-w-sm"
    role="alert"
    aria-live="polite"
>
    <div
        x-show="show"
        :class="type === 'error' ? 'bg-red-600 text-white' : 'bg-green-600 text-white'"
        class="rounded-lg shadow-lg px-4 py-3 text-sm font-medium"
    >
        <span x-text="message"></span>
    </div>
</div>
