<x-notebook::layouts.master title="Caderno — Oh Pro!">
    <div class="w-full max-w-4xl mx-auto space-y-8">
        <header>
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <x-icon name="book" style="duotone" class="text-indigo-500" />
                Caderno
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">
                Rubricas, notas e chamada por turma.
            </p>
        </header>

        {{-- Rubricas --}}
        <section class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                <x-icon name="list-check" style="duotone" class="text-indigo-500" />
                Rubricas
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                Configure critérios e níveis de avaliação para usar em atividades.
            </p>
            <a href="{{ route('notebook.rubrics.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                <x-icon name="cog" style="duotone" class="fa-sm" />
                Ir para Rubricas
            </a>
        </section>

        {{-- Notas por turma --}}
        <section class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                <x-icon name="table-list" style="duotone" class="text-indigo-500" />
                Notas
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                Planilha de notas por turma. Selecione a turma para lançar ou consultar notas.
            </p>
            @if($schoolClasses->isEmpty())
                <p class="text-slate-500 dark:text-slate-400 text-sm">Crie uma turma no Workspace para usar notas.</p>
                <a href="{{ route('workspace.index') }}" class="mt-3 inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">Ir ao Workspace</a>
            @else
                <ul class="space-y-2">
                    @foreach($schoolClasses as $schoolClass)
                        <li>
                            <a href="{{ route('notebook.grades', $schoolClass) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <x-icon name="chalkboard-user" style="duotone" class="fa-sm" />
                                {{ $schoolClass->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        {{-- Chamada por turma --}}
        <section class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                <x-icon name="user-check" style="duotone" class="text-indigo-500" />
                Chamada
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                Registro de presença por turma e data.
            </p>
            @if($schoolClasses->isEmpty())
                <p class="text-slate-500 dark:text-slate-400 text-sm">Crie uma turma no Workspace para fazer chamada.</p>
                <a href="{{ route('workspace.index') }}" class="mt-3 inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:underline text-sm font-medium">Ir ao Workspace</a>
            @else
                <ul class="space-y-2">
                    @foreach($schoolClasses as $schoolClass)
                        <li>
                            <a href="{{ route('notebook.attendance', $schoolClass) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <x-icon name="chalkboard-user" style="duotone" class="fa-sm" />
                                {{ $schoolClass->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</x-notebook::layouts.master>
