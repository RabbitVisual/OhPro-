<x-layouts.app-sidebar title="Marketplace — Oh Pro!">
    <div class="max-w-6xl mx-auto">
        <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                    <x-icon name="store" style="duotone" class="text-indigo-500" />
                    Marketplace
                </h1>
                <p class="mt-1 text-slate-500 dark:text-slate-400">
                    Explore e publique planos de aula e materiais.
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('marketplace.index', ['mine' => 1]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800">
                    Meus anúncios
                </a>
                <a href="{{ route('marketplace.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    <x-icon name="plus" style="duotone" class="fa-sm" />
                    Publicar
                </a>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($items as $item)
                <a href="{{ route('marketplace.show', $item) }}" class="block rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 overflow-hidden hover:shadow-lg transition-shadow">
                    @if($item->preview_path)
                        <div class="aspect-video bg-slate-100 dark:bg-slate-700">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($item->preview_path) }}" alt="" class="w-full h-full object-cover" />
                        </div>
                    @else
                        <div class="aspect-video bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                            <x-icon name="file" style="duotone" class="w-12 h-12 text-slate-400" />
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-900 dark:text-white truncate">{{ $item->title }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ $item->user ? $item->user->first_name . ' ' . $item->user->last_name : '—' }}
                        </p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                R$ {{ number_format($item->price, 2, ',', '.') }}
                            </span>
                            @if($item->average_rating > 0)
                                <span class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $item->average_rating }} ★
                                </span>
                            @endif
                        </div>
                        <span class="inline-flex mt-2 px-2 py-0.5 rounded text-xs font-medium
                            @if($item->status === 'published') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($item->status === 'draft') bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300
                            @else bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300
                            @endif">
                            {{ $item->status === 'published' ? 'Publicado' : ($item->status === 'draft' ? 'Rascunho' : 'Suspenso') }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-12 text-center">
                    <x-icon name="store" style="duotone" class="w-16 h-16 mx-auto mb-4 text-slate-400" />
                    <p class="text-slate-500 dark:text-slate-400">Nenhum anúncio no marketplace.</p>
                    <a href="{{ route('marketplace.create') }}" class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Publicar o primeiro</a>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>
</x-layouts.app-sidebar>
