<x-workspace::layouts.master>
    <div class="min-h-screen p-4 md:p-6">
        <div class="mb-6">
            <a href="{{ route('workspace.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar ao workspace
            </a>
        </div>

        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
            <x-icon name="chalkboard-user" style="duotone" />
            {{ $schoolClass->name }}
        </h1>
        @if($schoolClass->subject || $schoolClass->grade_level)
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                {{ implode(' · ', array_filter([$schoolClass->grade_level, $schoolClass->subject])) }}
            </p>
        @endif

        <div class="flex flex-wrap gap-3 mb-8">
            <form action="{{ route('workspace.launch', $schoolClass) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <x-icon name="play" style="duotone" class="fa-sm" />
                    Iniciar aula
                </button>
            </form>
            <a href="{{ route('notebook.attendance', $schoolClass) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="user-check" style="duotone" class="fa-sm" />
                Chamada
            </a>
            <a href="{{ route('notebook.grades', $schoolClass) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="table-list" style="duotone" class="fa-sm" />
                Notas
            </a>
            @if($appliedPlan)
                <a href="{{ route('planning.show', $appliedPlan->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                    <x-icon name="book-open-reader" style="duotone" class="fa-sm" />
                    Ver plano
                </a>
            @endif
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif
    </div>
</x-workspace::layouts.master>
