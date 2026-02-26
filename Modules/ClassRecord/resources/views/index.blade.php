<x-layouts.app-sidebar title="Registros de turma — Oh Pro!">
    <div class="max-w-4xl mx-auto">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <x-icon name="chalkboard-user" style="duotone" class="text-indigo-500" />
                Registros de turma
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">
                Acesso rápido a boletins, chamada e workspace por turma.
            </p>
        </header>

        @if($schoolClasses->isEmpty())
            <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-8 text-center">
                <x-icon name="chalkboard-user" style="duotone" class="w-16 h-16 mx-auto mb-4 text-slate-400" />
                <p class="text-slate-500 dark:text-slate-400">Nenhuma turma encontrada.</p>
                <a href="{{ route('workspace.index') }}" class="mt-4 inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Criar turma no Workspace</a>
            </div>
        @else
            <ul class="space-y-3">
                @foreach($schoolClasses as $schoolClass)
                    <li class="flex items-center justify-between gap-4 p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <div>
                            <span class="font-medium text-slate-900 dark:text-white">{{ $schoolClass->name }}</span>
                            @if($schoolClass->school)
                                <span class="text-slate-500 dark:text-slate-400 text-sm"> — {{ $schoolClass->school->name }}</span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('notebook.grades', $schoolClass) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <x-icon name="table-list" style="duotone" class="fa-sm" />
                                Notas
                            </a>
                            <a href="{{ route('notebook.attendance', $schoolClass) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <x-icon name="user-check" style="duotone" class="fa-sm" />
                                Chamada
                            </a>
                            <a href="{{ route('workspace.show', $schoolClass) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                                <x-icon name="chalkboard" style="duotone" class="fa-sm" />
                                Workspace
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app-sidebar>
