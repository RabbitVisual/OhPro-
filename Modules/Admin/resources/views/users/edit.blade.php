<x-layouts.app-sidebar :title="$title ?? 'Editar Usuário'">
    <div class="min-h-screen p-4 md:p-6 flex justify-center">
        <div class="w-full max-w-2xl space-y-6">
            {{-- Header --}}
             <div class="flex items-center gap-4">
                <a href="{{ route('panel.admin.users.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div>
                    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                        Editar Usuário
                    </h1>
                </div>
            </div>

            <form action="{{ route('panel.admin.users.update', $user) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 md:p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('first_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sobrenome</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                             @error('last_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Função (Role)</label>
                        <select name="role" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                         @error('role') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-100 dark:border-gray-700/50 flex justify-end gap-3">
                    <a href="{{ route('panel.admin.users.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app-sidebar>
