<x-planning::layouts.master title="Editar plano">
    <div class="p-4 md:p-6 max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="book-open-reader" style="duotone" />
                {{ $plan->title }}
            </h1>
            <div class="flex gap-2">
                <a href="{{ route('planning.index') }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm">Voltar</a>
            </div>
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif

        <form action="{{ route('planning.update', $plan->id) }}" method="POST" id="planning-edit-form">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $plan->title) }}" required
                           class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">
                </div>
                @php $contentsByKey = $plan->contents->keyBy('field_key'); @endphp
                @foreach($plan->contents->sortBy('sort_order') as $content)
                    <div>
                        <label for="contents_{{ $content->field_key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $content->field_key)) }}</label>
                        <textarea name="contents[{{ $content->field_key }}]" id="contents_{{ $content->field_key }}" rows="3"
                                  class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">{{ old('contents.'.$content->field_key, $content->value) }}</textarea>
                    </div>
                @endforeach
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas</label>
                    <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">{{ old('notes', $plan->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-planning::layouts.master>
