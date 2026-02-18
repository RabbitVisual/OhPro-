<x-planning::layouts.master title="{{ $plan->title }}">
    <div class="p-4 md:p-6 max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">{{ $plan->title }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('planning.edit', $plan->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm">Editar</a>
                <a href="{{ route('planning.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm">Voltar</a>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 space-y-4">
            @foreach($plan->contents->sortBy('sort_order') as $content)
                @if($content->value)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $content->field_key)) }}</h3>
                        <p class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $content->value }}</p>
                    </div>
                @endif
            @endforeach
            @if($plan->notes)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Notas</h3>
                    <p class="mt-1 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $plan->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-planning::layouts.master>
