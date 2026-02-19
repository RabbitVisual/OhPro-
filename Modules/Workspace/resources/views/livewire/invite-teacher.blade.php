<div>
    <div class="space-y-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="users-gear" style="duotone" class="text-indigo-500" />
                Professores Colaboradores
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Convide outros professores para colaborar nesta turma. Eles terão acesso para visualizar e editar notas, faltas e diários.
            </p>
        </div>

        {{-- Invite Form --}}
        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
            <form wire:submit.prevent="invite" class="flex flex-col sm:flex-row gap-3 items-start">
                <div class="flex-1 w-full">
                    <label for="email" class="sr-only">Email do Professor</label>
                    <input type="email" wire:model="email" id="email" class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-white dark:bg-gray-700 dark:text-gray-200" placeholder="Digite o email do professor cadastrado">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto justify-center">
                    <x-icon name="paper-plane" class="mr-2 h-4 w-4" />
                    Convidar
                </button>
            </form>

            @if (session()->has('success'))
                <div class="mt-3 text-sm text-green-600 dark:text-green-400 flex items-center gap-1">
                    <x-icon name="check-circle" class="h-4 w-4" />
                    {{ session('success') }}
                </div>
            @endif
        </div>

        {{-- Contributors List --}}
        <div>
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Colaboradores Ativos</h4>

            <ul class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                {{-- Owner (You) --}}
                <li class="p-4 flex items-center justify-between bg-gray-50 dark:bg-gray-700/30">
                    <div class="flex items-center gap-3">
                        <div class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold">
                            {{ substr($schoolClass->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $schoolClass->user->name }}
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">Proprietário</span>
                            </p>
                            <p class="text-xs text-gray-500">{{ $schoolClass->user->email }}</p>
                        </div>
                    </div>
                </li>

                {{-- Contributors --}}
                @forelse($contributors as $contributor)
                <li class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full w-8 h-8 flex items-center justify-center text-xs font-bold">
                            {{ substr($contributor->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $contributor->name }}</p>
                            <p class="text-xs text-gray-500">{{ $contributor->email }}</p>
                        </div>
                    </div>

                    @if($schoolClass->isOwner(auth()->user()))
                    <button wire:click="removeTeacher({{ $contributor->id }})" wire:confirm="Tem certeza que deseja remover o acesso deste professor?" class="text-gray-400 hover:text-red-500 p-1 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Remover acesso">
                        <x-icon name="trash" class="w-4 h-4" />
                    </button>
                    @endif
                </li>
                @empty
                @if(!$contributors->count())
                <li class="p-4 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                    Nenhum colaborador adicionado ainda.
                </li>
                @endif
                @endforelse
            </ul>
        </div>
    </div>
</div>
