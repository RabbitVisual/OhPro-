<div class="p-4 md:p-6">
    <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
        <x-icon name="user-check" style="duotone" />
        Chamada rápida
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Data: {{ \Carbon\Carbon::parse($date)->translatedFormat('d/m/Y') }}</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($rows as $row)
            <button
                type="button"
                wire:click="toggle({{ $row['student']->id }}, {{ $row['present'] ? 'false' : 'true' }})"
                class="flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all min-h-[120px] {{ $row['present'] ? 'bg-green-50 dark:bg-green-900/20 border-green-400 dark:border-green-600 text-green-800 dark:text-green-200' : 'bg-red-50 dark:bg-red-900/20 border-red-400 dark:border-red-600 text-red-800 dark:text-red-200' }}"
            >
                @if($row['present'])
                    <x-icon name="user-check" style="duotone" class="text-3xl mb-2" />
                @else
                    <x-icon name="user-xmark" style="duotone" class="text-3xl mb-2" />
                @endif
                <span class="text-sm font-medium text-center break-words">{{ $row['student']->name }}</span>
            </button>
        @endforeach
    </div>

    @if(empty($rows))
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
            <x-icon name="users" style="duotone" class="fa-3x mx-auto mb-3 opacity-50" />
            <p class="font-medium">Nenhum aluno na turma.</p>
            <p class="text-sm mt-1">Adicione alunos à turma para fazer a chamada.</p>
        </div>
    @endif
</div>
