<x-layouts.app-sidebar title="{{ $schoolClass->name }} — Registros">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('classrecord.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:underline flex items-center gap-1 mb-6 w-fit">
            <x-icon name="arrow-left" style="duotone" class="fa-sm" />
            Voltar aos registros
        </a>

        <header class="mb-8">
            <h1 class="text-2xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <x-icon name="chalkboard-user" style="duotone" class="text-indigo-500" />
                {{ $schoolClass->name }}
            </h1>
            @if($schoolClass->school)
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $schoolClass->school->name }}</p>
            @endif
        </header>

        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
            <a href="{{ route('notebook.grades', $schoolClass) }}" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                    <x-icon name="table-list" style="duotone" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                </div>
                <div>
                    <span class="font-medium text-slate-900 dark:text-white">Notas</span>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Planilha de notas e boletim</p>
                </div>
                <x-icon name="chevron-right" style="duotone" class="w-5 h-5 text-slate-400 ml-auto" />
            </a>
            <a href="{{ route('notebook.attendance', $schoolClass) }}" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="p-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                    <x-icon name="user-check" style="duotone" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                </div>
                <div>
                    <span class="font-medium text-slate-900 dark:text-white">Chamada</span>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Registro de presença</p>
                </div>
                <x-icon name="chevron-right" style="duotone" class="w-5 h-5 text-slate-400 ml-auto" />
            </a>
            <a href="{{ route('workspace.show', $schoolClass) }}" class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                <div class="p-2 rounded-lg bg-slate-100 dark:bg-slate-700">
                    <x-icon name="chalkboard" style="duotone" class="w-5 h-5 text-slate-600 dark:text-slate-300" />
                </div>
                <div>
                    <span class="font-medium text-slate-900 dark:text-white">Workspace</span>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Iniciar aula e configurações da turma</p>
                </div>
                <x-icon name="chevron-right" style="duotone" class="w-5 h-5 text-slate-400 ml-auto" />
            </a>
        </div>
    </div>
</x-layouts.app-sidebar>
