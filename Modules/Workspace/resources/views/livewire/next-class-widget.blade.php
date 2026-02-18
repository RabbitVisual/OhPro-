<div class="mb-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 md:p-6">
    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
        <x-icon name="clock-desk" style="duotone" />
        <x-icon name="bolt" style="duotone" class="fa-sm ml-1" />
        Sua Próxima Aula
    </h2>
    @if($nextClass)
        @php
            $class = $nextClass['class'];
            $at = $nextClass['at'];
        @endphp
        <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $class->name }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $at->translatedFormat('l, d/m/Y') }} às {{ $at->format('H:i') }}
            @if($class->school)
                · {{ $class->school->short_name ?: $class->school->name }}
            @endif
        </p>
        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('workspace.launch', $class) }}" method="post" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700"
                onclick="event.preventDefault(); document.getElementById('launch-{{ $class->id }}').submit();">
                <x-icon name="play" style="duotone" class="fa-sm" />
                Iniciar Aula
            </a>
            <form id="launch-{{ $class->id }}" action="{{ route('workspace.launch', $class) }}" method="POST" class="hidden">
                @csrf
            </form>
            <a href="{{ route('notebook.attendance', $class) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="user-check" style="duotone" class="fa-sm" />
                Fazer Chamada
            </a>
            <a href="{{ route('workspace.show', $class) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="book-open-reader" style="duotone" class="fa-sm" />
                Ver plano
            </a>
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">Nenhuma aula agendada. Cadastre horários nas turmas.</p>
    @endif
</div>
