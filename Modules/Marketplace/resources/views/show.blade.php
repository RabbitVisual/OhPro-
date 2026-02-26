<x-layouts.app-sidebar title="{{ Str::limit($item->title, 40) }} — Marketplace">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('marketplace.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:underline flex items-center gap-1 mb-6 w-fit">
            <x-icon name="arrow-left" style="duotone" class="fa-sm" />
            Voltar ao Marketplace
        </a>

        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 overflow-hidden shadow-sm">
            @if($item->preview_path)
                <div class="aspect-video bg-slate-100 dark:bg-slate-700">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item->preview_path) }}" alt="" class="w-full h-full object-cover" />
                </div>
            @endif
            <div class="p-6 md:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-display font-bold text-slate-900 dark:text-white">{{ $item->title }}</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">
                            {{ $item->user ? $item->user->first_name . ' ' . $item->user->last_name : '—' }}
                        </p>
                    </div>
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        R$ {{ number_format($item->price, 2, ',', '.') }}
                    </div>
                </div>
                <div class="mt-6 prose dark:prose-invert max-w-none">
                    <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $item->description }}</p>
                </div>
                @if($item->user_id === auth()->id())
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('marketplace.edit', $item) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">Editar anúncio</a>
                    </div>
                @endif
            </div>

            @if($item->reviews->isNotEmpty())
                <div class="px-6 md:px-8 pb-6 border-t border-slate-200 dark:border-slate-700 pt-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Avaliações ({{ $item->reviews->count() }})</h2>
                    <ul class="space-y-3">
                        @foreach($item->reviews as $review)
                            <li class="flex gap-3">
                                <div class="flex-1 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                        {{ $review->user ? $review->user->first_name : 'Anônimo' }} · {{ $review->created_at->translatedFormat('d/m/Y') }}
                                        <span class="text-amber-500">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="mt-1 text-slate-700 dark:text-slate-300 text-sm">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app-sidebar>
