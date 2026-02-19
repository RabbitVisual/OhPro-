<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
        <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="shield-check" class="text-emerald-500" />
            Feed de Segurança
        </h3>
        <span class="text-xs text-gray-500">Últimas atividades</span>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-700">
        @foreach($logs as $log)
            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-xs font-bold">
                            {{ $log->user ? substr($log->user->name, 0, 1) : '?' }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                <span class="font-bold">{{ $log->action }}</span>
                                <span class="text-gray-500 font-normal">por {{ $log->user->name ?? 'Sistema/Desconhecido' }}</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $log->description }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                        <p class="text-[10px] text-gray-400">{{ $log->ip_address }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        {{ $logs->links() }}
    </div>
</div>
