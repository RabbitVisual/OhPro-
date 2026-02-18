<x-layouts.app-sidebar :title="$title ?? 'Saúde do Sistema'">
    <div class="min-h-screen p-4 md:p-6 space-y-6" x-data="{ tab: 'activity' }">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                Saúde do Sistema
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">
                Monitore logs e atividades recentes.
            </p>
        </div>

        {{-- Tabs --}}
        <div class="border-b border-gray-100 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'activity'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'activity', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'activity'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Atividade Recente
                </button>
                <button @click="tab = 'logs'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'logs', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'logs'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Logs do Sistema
                </button>
            </nav>
        </div>

        {{-- Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content Area --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Recent Activity Tab --}}
                <div x-show="tab === 'activity'" x-transition class="space-y-4">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Últimas Alterações</h3>
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @forelse($activities as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800
                                                    {{ $activity['type'] == 'user' ? 'bg-blue-500' : ($activity['type'] == 'school' ? 'bg-emerald-500' : 'bg-amber-500') }}">

                                                    @if($activity['type'] == 'user')
                                                        <x-icon name="user" class="h-4 w-4 text-white" />
                                                    @elseif($activity['type'] == 'school')
                                                        <x-icon name="school" class="h-4 w-4 text-white" />
                                                    @else
                                                        <x-icon name="file-invoice" class="h-4 w-4 text-white" />
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $activity['description'] }}
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $activity['time']->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="text-center py-8 text-gray-500">
                                    Nenhuma atividade recente registrada.
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Logs Tab --}}
                <div x-show="tab === 'logs'" x-transition style="display: none;">
                    <div class="bg-gray-900 rounded-2xl shadow-sm border border-gray-800 p-4 font-mono text-xs text-green-400 h-[600px] overflow-y-auto custom-scrollbar">
                        @foreach($logs as $line)
                            @if(trim($line))
                                <div class="py-0.5 hover:bg-gray-800 px-2 rounded cursor-default break-words">
                                    {{ $line }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Sidebar Status --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 p-6">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                        Status do Servidor
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">Ambiente</span>
                                <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ app()->environment() }}</span>
                            </div>
                        </div>
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">Debug Mode</span>
                                <span class="font-medium {{ config('app.debug') ? 'text-amber-500' : 'text-emerald-500' }}">
                                    {{ config('app.debug') ? 'Ativado' : 'Desativado' }}
                                </span>
                            </div>
                        </div>
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">PHP Version</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ phpversion() }}</span>
                            </div>
                        </div>
                         <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">Laravel Version</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ app()->version() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
