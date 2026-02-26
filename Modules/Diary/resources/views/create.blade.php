<x-diary::layouts.master title="Novo registro de aula">
    <div class="w-full">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight">Novo registro de aula</h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">Para iniciar uma nova aula, use o Workspace e clique em &quot;Iniciar aula&quot; na turma desejada.</p>
        </header>
        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 p-6">
            <a href="{{ route('workspace.index') }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-medium hover:underline">
                <x-icon name="chalkboard" style="duotone" class="w-5 h-5" />
                Ir ao Workspace para iniciar uma aula
            </a>
        </div>
    </div>
</x-diary::layouts.master>
