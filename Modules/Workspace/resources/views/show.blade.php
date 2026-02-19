<x-workspace::layouts.master>
    <div class="min-h-screen p-4 md:p-6">
        <div class="mb-6">
            <a href="{{ route('workspace.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar ao workspace
            </a>
        </div>

        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
            <x-icon name="chalkboard-user" style="duotone" />
            {{ $schoolClass->name }}
        </h1>
        @if($schoolClass->subject || $schoolClass->grade_level)
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                {{ implode(' · ', array_filter([$schoolClass->grade_level, $schoolClass->subject])) }}
            </p>
        @endif

        <div class="flex flex-wrap gap-3 mb-8">
            <form action="{{ route('workspace.launch', $schoolClass) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <x-icon name="play" style="duotone" class="fa-sm" />
                    Iniciar aula
                </button>
            </form>
            <a href="{{ route('notebook.attendance', $schoolClass) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="user-check" style="duotone" class="fa-sm" />
                Chamada
            </a>
            <a href="{{ route('notebook.grades', $schoolClass) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="table-list" style="duotone" class="fa-sm" />
                Notas
            </a>
            @if($appliedPlan)
                <a href="{{ route('planning.show', $appliedPlan->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                    <x-icon name="book-open-reader" style="duotone" class="fa-sm" />
                    Ver plano
                </a>
            @endif
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif

        <div x-data="{ showSettings: false }">
            <div class="flex justify-end mb-4">
                 <button @click="showSettings = true" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 text-sm flex items-center gap-1 transition-colors">
                    <x-icon name="cog" style="duotone" class="w-4 h-4" />
                    Configurações da Turma
                </button>
            </div>

            {{-- Settings Modal --}}
            <div x-show="showSettings" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showSettings" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showSettings = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showSettings" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                        Configurações da Turma
                                    </h3>
                                    <div class="mt-4">
                                        <livewire:workspace.invite-teacher :schoolClass="$schoolClass" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showSettings = false">
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-workspace::layouts.master>
