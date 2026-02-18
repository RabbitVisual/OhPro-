<x-planning::layouts.master title="Galeria da Comunidade">
    <div class="p-4 md:p-6 max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="globe-americas" style="duotone" />
                Galeria da Comunidade
            </h1>
            <a href="{{ route('planning.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm">Meus planos</a>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Planos de aula compartilhados por outros professores. Clique em &quot;Clonar&quot; para copiar um plano para sua lista e adaptar.</p>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="mb-4 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($plans as $plan)
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 flex flex-col">
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $plan->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ ucfirst($plan->template_key) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 line-clamp-2">
                        @php
                            $firstContent = $plan->contents->first();
                        @endphp
                        {{ $firstContent ? \Illuminate\Support\Str::limit(strip_tags($firstContent->value), 80) : '—' }}
                    </p>
                    <div class="mt-auto pt-4 flex gap-2">
                        <form action="{{ route('planning.clone', $plan->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                                <x-icon name="copy" style="duotone" class="fa-sm" />
                                Clonar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    <x-icon name="globe-americas" style="duotone" class="fa-2xl mx-auto mb-2 opacity-50" />
                    <p>Nenhum plano compartilhado na galeria ainda.</p>
                    <p class="text-sm mt-1">Marque um plano como &quot;Disponibilizar na Galeria da Comunidade&quot; na edição para compartilhar.</p>
                </div>
            @endforelse
        </div>

        @if($plans->hasPages())
            <div class="mt-6">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</x-planning::layouts.master>
