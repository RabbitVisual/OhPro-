<div x-data="commandPalette()"
     @keydown.window.prevent.ctrl.k="open = true"
     @keydown.window.prevent.meta.k="open = true"
     @open-command-palette.window="open = true"
     class="relative z-50"
     x-cloak
     x-show="open">

    <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <div class="mx-auto max-w-xl transform divide-y divide-gray-100 dark:divide-gray-700 overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
             x-show="open"
             @click.away="open = false"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="relative">
                <x-icon name="search" class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" />
                <input type="text"
                       x-ref="input"
                       x-model.debounce.300ms="query"
                       class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-0 sm:text-sm"
                       placeholder="Buscar no sistema..."
                       role="combobox"
                       aria-expanded="false"
                       aria-controls="options">
            </div>

            <ul class="max-h-80 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800 dark:text-gray-200" id="options" role="listbox">
                <template x-if="results.length > 0">
                    <template x-for="(result, index) in results" :key="index">
                        <li class="cursor-pointer select-none px-4 py-2 hover:bg-indigo-600 hover:text-white group"
                            role="option"
                            tabindex="-1"
                            @click="window.location.href = result.url">
                            <div class="flex items-center gap-3">
                                <span class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-white/20 text-gray-500 dark:text-gray-400 group-hover:text-white">
                                    <i :class="['fa-duotone', 'fa-' + (result.icon || 'circle')]"></i>
                                </span>
                                <div class="flex-auto">
                                   <p class="font-medium" x-text="result.title"></p>
                                   <p class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-200" x-text="result.subtitle"></p>
                                </div>
                            </div>
                        </li>
                    </template>
                </template>

                <template x-if="query.length > 0 && results.length === 0 && !loading">
                     <li class="px-4 py-12 text-center text-sm sm:px-14">
                        <x-icon name="search" style="duotone" class="mx-auto h-6 w-6 text-gray-400" />
                        <p class="mt-4 font-semibold text-gray-900 dark:text-white">Nada encontrado</p>
                        <p class="mt-2 text-gray-500">Não encontramos nada com esse termo.</p>
                    </li>
                </template>

                 <template x-if="query.length === 0">
                     <li class="px-4 py-4 text-xs text-gray-500 dark:text-gray-400">
                        Comece a digitar para buscar...
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>

<script>
    function commandPalette() {
        return {
            open: false,
            query: '',
            results: [],
            loading: false,
            init() {
                this.$watch('open', value => {
                    if (value) {
                        this.$nextTick(() => this.$refs.input.focus());
                    }
                });
                this.$watch('query', value => {
                    if (value.length >= 2) {
                        this.search();
                    } else {
                        this.results = [];
                    }
                });
            },
            search() {
                this.loading = true;
                fetch(`/api/quick-search?q=${encodeURIComponent(this.query)}`)
                    .then(res => res.json())
                    .then(data => {
                        this.results = data;
                        this.loading = false;
                    })
                    .catch(() => {
                        this.loading = false;
                    });
            }
        }
    }
</script>
