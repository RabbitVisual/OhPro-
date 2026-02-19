<x-layouts.guest-portfolio :title="$student->name">

    {{-- Student Header --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 mb-6 text-center">
        <div class="w-20 h-20 mx-auto bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-2xl mb-3">
            {{ substr($student->name, 0, 1) }}
        </div>
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white">{{ $student->name }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $student->schoolClasses->first()?->name ?? 'Turma' }}</p>
    </div>

    {{-- Grades Summary --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4 border border-indigo-100 dark:border-indigo-800 text-center">
            <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">Média Geral</p>
            <p class="text-2xl font-bold text-indigo-900 dark:text-white">
                {{ number_format($student->portfolioEntries->avg('grade') ?? 0, 1) }}
            </p>
        </div>
        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4 border border-emerald-100 dark:border-emerald-800 text-center">
            <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">Presença</p>
            <p class="text-2xl font-bold text-emerald-900 dark:text-white">
                {{ number_format(95, 0) }}%
                {{-- Placeholder for attendance --}}
            </p>
        </div>
    </div>

    {{-- Timeline --}}
    <div class="space-y-6">
        <h2 class="font-display font-bold text-lg text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="timeline" style="duotone" class="text-indigo-500" />
            Linha do Tempo
        </h2>

        @forelse($student->portfolioEntries as $entry)
            <div class="relative pl-8 pb-6 border-l-2 border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white dark:bg-gray-900 border-2 border-indigo-500"></div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700/50">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-semibold px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            {{ $entry->created_at->format('d/m/Y') }}
                        </span>
                        @if($entry->grade)
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">Nota: {{ $entry->grade }}</span>
                        @endif
                    </div>

                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $entry->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $entry->description }}</p>

                    @if($entry->media_url)
                        <div class="rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                            <img src="{{ $entry->media_url }}" alt="Anexo" class="w-full h-auto object-cover max-h-48">
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                <x-icon name="folder-open" style="duotone" class="fa-2x mb-3 opacity-50" />
                <p>Nenhuma atividade registrada ainda.</p>
            </div>
        @endforelse
    </div>
</x-layouts.guest-portfolio>
