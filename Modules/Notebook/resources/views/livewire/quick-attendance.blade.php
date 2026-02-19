    <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
        <x-icon name="user-check" style="duotone" />
        Chamada rápida
    </h1>
    <div class="flex justify-between items-end mb-6">
        <p class="text-sm text-gray-500 dark:text-gray-400">Data: {{ \Carbon\Carbon::parse($date)->translatedFormat('d/m/Y') }}</p>
        <button
            wire:click="$dispatch('open-scanner')"
            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors font-medium shadow-lg shadow-indigo-200 dark:shadow-none"
        >
            <x-icon name="qrcode" style="duotone" />
            Scanner
        </button>
        <a
            href="{{ route('notebook.classes.print-cards', $schoolClassId) }}"
            target="_blank"
            class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium ml-2"
        >
            <x-icon name="print" style="duotone" />
            Imprimir Cartões
        </a>
    </div>

    <livewire:notebook.attendance-scanner :schoolClassId="$schoolClassId" :date="$date" wire:key="scanner-{{ $schoolClassId }}" />

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
