@props(['faq', 'id'])
<div x-data="{ open: false }" class="rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 overflow-hidden transition-colors hover:border-slate-300 dark:hover:border-slate-600" :class="open && 'border-indigo-400 dark:border-indigo-600'">
    <button type="button" @click="open = !open" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4">
        <span class="font-semibold text-slate-800 dark:text-slate-100 leading-snug" :class="open && 'text-indigo-600 dark:text-indigo-400'">{{ $faq['q'] }}</span>
        <span class="shrink-0 w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center transition-all duration-200" :class="open && 'bg-indigo-600 text-white rotate-180'">
            <x-icon name="chevron-down" style="duotone" class="fa-sm" />
        </span>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="border-t border-slate-100 dark:border-slate-800">
        <div class="px-5 py-4 flex gap-4">
            <div class="w-1 rounded-full bg-indigo-500/60 shrink-0 hidden sm:block"></div>
            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ $faq['a'] }}</p>
        </div>
    </div>
</div>
