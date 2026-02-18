<x-layouts.app :title="($school->name ?? '') . ' - Gestão'">
    <div class="min-h-screen p-4 md:p-6">
        <div class="mb-6">
            <a href="{{ route('manager.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar às escolas
            </a>
        </div>
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
            <x-icon name="building" style="duotone" />
            {{ $school->name }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8">Painel institucional</p>

        <div class="mb-8">
            <a href="{{ route('manager.diary.pdf', $school) }}?month={{ now()->format('Y-m') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                <x-icon name="file-pdf" style="duotone" class="fa-sm" />
                Exportar diário do mês (PDF)
            </a>
        </div>

        <div class="grid gap-8 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="chalkboard-user" style="duotone" class="fa-sm" />
                    Professores
                </h2>
                <ul class="space-y-2">
                    @forelse($teachers as $teacher)
                    <li class="text-gray-700 dark:text-gray-300 font-sans">{{ $teacher->full_name }} <span class="text-gray-500 text-sm">{{ $teacher->email }}</span></li>
                    @empty
                    <li class="text-gray-500 dark:text-gray-400">Nenhum professor com turma nesta escola.</li>
                    @endforelse
                </ul>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="triangle-exclamation" style="duotone" class="fa-sm" />
                    Mapa de atenção (ciclo {{ $cycle }})
                </h2>
                <ul class="space-y-2 max-h-64 overflow-y-auto">
                    @forelse($atRisk as $item)
                    <li class="text-sm">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $item['student']->name }}</span>
                        <span class="text-gray-500"> — {{ $item['school_class']->name }}</span>
                        <span class="text-amber-600 dark:text-amber-400"> {{ implode(', ', $item['reasons']) }}</span>
                        <a href="{{ $item['grades_url'] }}" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1">Ver notas</a>
                    </li>
                    @empty
                    <li class="text-gray-500 dark:text-gray-400">Nenhum aluno em situação de atenção no ciclo atual.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
