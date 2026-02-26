<x-library::layouts.master>
    <div class="py-2">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                    <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                    Voltar
                </a>
                <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="folder-open" style="duotone" />
                    Minha biblioteca
                </h1>
            </div>
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="mb-4 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
        @endif

        {{-- Upload --}}
        <div class="mb-8 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="file-arrow-up" style="duotone" class="fa-sm" />
                Enviar arquivo
            </h2>
            <form action="{{ route('library.store') }}" method="post" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <input type="file" name="file" required class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máx. 50 MB. PDF, imagens, documentos.</p>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <select name="lesson_plan_id" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2 min-w-[180px]">
                        <option value="">— Plano de aula (opcional)</option>
                        @foreach($lessonPlans as $lp)
                            <option value="{{ $lp->id }}">{{ Str::limit($lp->title, 40) }}</option>
                        @endforeach
                    </select>
                    <select name="school_class_id" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2 min-w-[180px]">
                        <option value="">— Turma (opcional)</option>
                        @foreach($schoolClasses as $sc)
                            <option value="{{ $sc->id }}">{{ Str::limit($sc->name, 40) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                        <x-icon name="upload" style="duotone" class="fa-sm" />
                        Enviar
                    </button>
                </div>
            </form>
        </div>

        {{-- Filters --}}
        <form method="get" action="{{ route('library.index') }}" class="mb-4 flex flex-wrap gap-2">
            <select name="lesson_plan_id" onchange="this.form.submit()" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                <option value="">Todos os planos</option>
                @foreach($lessonPlans as $lp)
                    <option value="{{ $lp->id }}" @selected(request('lesson_plan_id') == $lp->id)>{{ Str::limit($lp->title, 35) }}</option>
                @endforeach
            </select>
            <select name="school_class_id" onchange="this.form.submit()" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                <option value="">Todas as turmas</option>
                @foreach($schoolClasses as $sc)
                    <option value="{{ $sc->id }}" @selected(request('school_class_id') == $sc->id)>{{ Str::limit($sc->name, 35) }}</option>
                @endforeach
            </select>
        </form>

        {{-- File list --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
            @if($files->isEmpty())
                <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                    <x-icon name="folder-open" style="duotone" class="fa-3x mx-auto mb-3 opacity-50" />
                    <p>Nenhum arquivo na biblioteca. Envie um arquivo acima.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Arquivo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Plano / Turma</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tamanho</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($files as $file)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-2 text-gray-900 dark:text-white">
                                        <x-icon name="file" style="duotone" class="fa-sm text-gray-500" />
                                        {{ Str::limit($file->name, 50) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    @if($file->lessonPlan) {{ Str::limit($file->lessonPlan->title, 25) }} @else — @endif
                                    @if($file->schoolClass) · {{ Str::limit($file->schoolClass->name, 25) }} @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-gray-600 dark:text-gray-400">
                                    {{ number_format($file->size / 1024, 1, ',', '') }} KB
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('library.download', $file) }}" class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Download</a>
                                    <form action="{{ route('library.destroy', $file) }}" method="post" class="inline ml-2" onsubmit="return confirm('Remover este arquivo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:underline text-sm">Excluir</button>
                                    </form>
                                    <button x-data x-on:click="$dispatch('open-publish-modal', { type: 'library_file', id: {{ $file->id }} })" class="inline ml-2 text-emerald-600 dark:text-emerald-400 hover:underline text-sm">
                                        Vender
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $files->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
    <livewire:marketplace.publish-item />
</x-library::layouts.master>
