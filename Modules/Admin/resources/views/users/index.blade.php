<x-layouts.app-sidebar :title="$title ?? 'Gerenciar Usuários'">
    <div class="min-h-screen p-4 md:p-6 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                    Gerenciar Usuários
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Visualize e gerencie professores e gestores.
                </p>
            </div>
            {{-- Search Placeholder --}}
            <div class="relative">
                <input type="text" placeholder="Buscar usuário..." class="pl-10 pr-4 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full md:w-64 text-sm">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <x-icon name="search" class="w-4 h-4" />
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 uppercase tracking-wider text-xs font-semibold">
                            <th class="px-6 py-4">Usuário</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status / Plano</th>
                            <th class="px-6 py-4">Registrado em</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ $user->getRoleNames()->first() ?? 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $sub = $user->subscriptions->where('status', 'active')->first();
                                @endphp
                                @if($sub && $sub->plan)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $sub->plan->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Grátis/Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     @if(!$sub || !$sub->plan->isPro())
                                        <form action="{{ route('panel.admin.users.upgrade', $user) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja promover este usuário para PRO?')">
                                            @csrf
                                            <button type="submit" class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors" title="Upgrade para Pro">
                                                <x-icon name="crown" style="duotone" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    @endif

                                    <a href="#" class="p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        <x-icon name="pen" style="duotone" class="w-4 h-4" />
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <x-icon name="users-slash" style="duotone" class="w-8 h-8 mb-3 text-gray-300 dark:text-gray-600" />
                                    <p>Nenhum usuário encontrado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
