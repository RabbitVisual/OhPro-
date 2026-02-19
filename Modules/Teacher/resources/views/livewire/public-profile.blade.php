<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        {{-- Profile Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            <div class="px-6 pb-6">
                <div class="relative flex justify-between items-end -mt-12 mb-4">
                    <div class="relative rounded-full border-4 border-white dark:border-gray-800 bg-white dark:bg-gray-700 p-1">
                        @if($user->photo)
                            <img src="{{ $user->photo }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                        @else
                            <div class="w-24 h-24 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-3xl font-bold">
                                {{ substr($user->first_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-3 mb-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone ?? '') }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 text-white font-medium hover:bg-green-600 transition-colors shadow-lg shadow-green-200 dark:shadow-none">
                            <x-icon name="whatsapp" style="brands" size="lg" />
                            Contratar
                        </a>
                    </div>
                </div>

                <div class="text-center sm:text-left">
                    <div class="flex items-center justify-center sm:justify-start gap-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                        @if($user->is_top_seller)
                            <div class="group relative">
                                <x-icon name="medal" style="duotone" class="text-yellow-500 text-xl" />
                                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Top Seller (50+ Vendas)</div>
                            </div>
                        @endif
                        @if($user->is_community_choice)
                            <div class="group relative">
                                <x-icon name="heart" style="duotone" class="text-red-500 text-xl" />
                                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Escolha da Comunidade (Nota > 4.8)</div>
                            </div>
                        @endif
                        @if($user->is_ai_pioneer)
                            <div class="group relative">
                                <x-icon name="robot" style="duotone" class="text-blue-500 text-xl" />
                                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Pioneiro IA (100+ Gerações)</div>
                            </div>
                        @endif
                    </div>
                    <p class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $user->public_title ?? 'Professor(a)' }}</p>

                    @if($user->bio)
                        <div class="mt-4 text-gray-600 dark:text-gray-300 max-w-2xl">
                            {{ $user->bio }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Marketplace Items --}}
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="shop" style="duotone" class="text-indigo-500" />
            Materiais à Venda
        </h2>

        @if($items->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <x-icon name="folder-open" style="duotone" size="3x" class="text-gray-400 mb-3" />
                <p class="text-gray-500 dark:text-gray-400">Este professor ainda não publicou materiais.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($items as $item)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
                        <div class="aspect-video bg-gray-100 dark:bg-gray-900 relative overflow-hidden flex items-center justify-center">
                            @if($item->preview_path)
                                <img src="{{ $item->preview_path }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                            @else
                                <x-icon name="file-pdf" style="duotone" size="3x" class="text-gray-400" />
                            @endif
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex items-center gap-1 mb-2">
                                @for($i=1; $i<=5; $i++)
                                    <x-icon name="star" style="{{ $i <= round($item->average_rating) ? 'solid' : 'regular' }}" class="{{ $i <= round($item->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} text-xs" />
                                @endfor
                                <span class="text-xs text-gray-500 ml-1">({{ $item->reviews_count }})</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2" title="{{ $item->title }}">
                                {{ $item->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mb-4 flex-1">
                                {{ $item->description }}
                            </p>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                    R$ {{ number_format($item->price, 2, ',', '.') }}
                                </span>
                                <button wire:click="buy({{ $item->id }})" wire:loading.attr="disabled" class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100 transition-colors disabled:opacity-50">
                                    <span wire:loading.remove wire:target="buy({{ $item->id }})">Comprar</span>
                                    <span wire:loading wire:target="buy({{ $item->id }})"><x-icon name="spinner" class="fa-spin" style="duotone" /></span>
                                </button>
                            </div>
                            <div class="mt-2 text-right">
                                <button wire:click="$dispatch('open-review-modal', { itemId: {{ $item->id }} })" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium dark:text-indigo-400 dark:hover:text-indigo-300">
                                    Avaliar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <livewire:marketplace.review-form />

        <div class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>Criado com <strong class="text-indigo-600">Vertex OhPro</strong></p>
        </div>
    </div>
</div>
