<div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50/50 dark:bg-amber-900/10 p-6 mb-6">
    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
        <x-icon name="triangle-exclamation" style="duotone" class="text-amber-600 dark:text-amber-400" />
        Mapa de Atenção
    </h2>
    @if($this->atRisk->isEmpty())
        <p class="text-sm text-gray-600 dark:text-gray-400">Nenhum aluno em situação de atenção no momento.</p>
    @else
        <ul class="space-y-2">
            @foreach($this->atRisk as $item)
                <li class="flex flex-wrap items-center justify-between gap-2 text-sm">
                    <span class="font-medium text-gray-900 dark:text-white">{{ $item['student']->name }}</span>
                    <span class="text-gray-600 dark:text-gray-400">{{ $item['school_class']->name }} @if($item['school_class']->school) · {{ $item['school_class']->school->short_name ?? $item['school_class']->school->name }} @endif</span>
                    <span class="text-amber-700 dark:text-amber-300">{{ implode(' · ', $item['reasons']) }}</span>
                    <a href="{{ $item['grades_url'] }}" class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        Ver caderno
                        <x-icon name="arrow-right" style="duotone" class="fa-xs" />
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
