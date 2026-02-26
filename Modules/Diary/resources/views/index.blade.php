<x-diary::layouts.master>
    <header class="mb-8">
        <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight">
            Diário de aulas
        </h1>
        <p class="mt-1 text-slate-500 dark:text-slate-400">
            Registros de aula e assinaturas. Para iniciar uma nova aula, vá ao Workspace e clique em &quot;Iniciar aula&quot; na turma.
        </p>
    </header>

    <div class="mb-6 rounded-xl border border-slate-200 dark:border-slate-700 bg-indigo-50 dark:bg-indigo-900/20 p-4">
        <a href="{{ route('workspace.index') }}" class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-medium hover:underline">
            <x-icon name="chalkboard" style="duotone" class="w-5 h-5" />
            Ir ao Workspace para iniciar uma aula
        </a>
    </div>

    <section>
        <h2 class="text-lg font-display font-bold text-slate-900 dark:text-white mb-4">Registros recentes</h2>
        @if($recentDiaries->isEmpty())
            <p class="text-slate-500 dark:text-slate-400 py-6">Nenhum registro de aula ainda. Inicie uma aula pelo Workspace.</p>
        @else
            <ul class="space-y-3">
                @foreach($recentDiaries as $diary)
                    <li class="flex items-center justify-between gap-4 p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                        <div>
                            <span class="font-medium text-slate-900 dark:text-white">{{ $diary->schoolClass->name ?? 'Turma' }}</span>
                            @if($diary->schoolClass && $diary->schoolClass->school)
                                <span class="text-slate-500 dark:text-slate-400 text-sm"> — {{ $diary->schoolClass->school->name }}</span>
                            @endif
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                                {{ $diary->scheduled_at?->translatedFormat('d/m/Y H:i') ?? $diary->created_at->translatedFormat('d/m/Y H:i') }}
                                @if($diary->is_finalized)
                                    <span class="text-emerald-600 dark:text-emerald-400">· Finalizado</span>
                                @else
                                    <span class="text-amber-600 dark:text-amber-400">· Rascunho</span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('diary.class.show', $diary) }}" class="shrink-0 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                            Abrir
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
</x-diary::layouts.master>
