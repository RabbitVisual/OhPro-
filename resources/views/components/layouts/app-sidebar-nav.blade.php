{{-- Sidebar content: logo + navigation. Rendered inside the sidebar column in app-sidebar. --}}
<div class="flex flex-col h-full w-full min-w-0 bg-white dark:bg-slate-900">
    <div class="flex items-center justify-center h-16 shrink-0 border-b border-slate-200 dark:border-slate-800 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-display font-bold text-xl text-slate-900 dark:text-white hover:opacity-90 transition-opacity">
            <x-icon name="chalkboard-user" style="duotone" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
            <span>Oh <span class="text-indigo-600 dark:text-indigo-400">Pro!</span></span>
        </a>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto min-h-0 custom-scrollbar">
        @role('teacher')
            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Professor</p>
            <x-nav-link route="teacher.index" icon="chart-pie" label="Visão geral" active="teacher.index" />
            <x-nav-link route="teacher.wallet" icon="wallet" label="Carteira" active="teacher.wallet" />
            <x-nav-link route="teacher.stats" icon="chart-line" label="Meu Ano em Dados" active="teacher.stats" />
            <x-nav-link route="workspace.index" icon="chalkboard" label="Workspace" active="workspace.*" />
            <x-nav-link route="planning.index" icon="calendar-alt" label="Planejamento" active="planning.*" />
            <x-nav-link route="notebook.index" icon="book" label="Caderno" active="notebook.*" />
            <x-nav-link route="diary.index" icon="pen-to-square" label="Diário" active="diary.*" />
            <x-nav-link route="library.index" icon="books" label="Biblioteca" active="library.*" />
        @endrole

        @role('manager')
            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Gestão</p>
            <x-nav-link route="dashboard" icon="chart-pie" label="Dashboard" active="dashboard" />
        @endrole

        @role('admin')
            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Administração</p>
            <x-nav-link route="panel.admin" icon="tachometer-alt" label="Dashboard" active="panel.admin" />
            <x-nav-link route="panel.admin.users.index" icon="users" label="Usuários" active="panel.admin.users.*" />
            <x-nav-link route="panel.admin.plans.index" icon="tags" label="Planos" active="panel.admin.plans.*" />
            <x-nav-link route="panel.admin.subscriptions" icon="credit-card" label="Assinaturas" active="panel.admin.subscriptions*" />
            <x-nav-link route="panel.admin.tickets.index" icon="ticket-alt" label="Tickets" active="panel.admin.tickets.*" />
            <x-nav-link route="panel.admin.health" icon="heartbeat" label="Saúde do Sistema" active="panel.admin.health" />
        @endrole

        @role('teacher')
            <p class="px-3 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mt-4">Ajuda</p>
            <x-nav-link route="support.index" icon="life-ring" label="Suporte" active="support.*" />
        @endrole

        <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800">
            <x-nav-link route="profile.edit" icon="user-circle" label="Minha Conta" active="profile.*" />
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="w-full group flex items-center px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <x-icon name="sign-out-alt" style="duotone" class="mr-3 h-5 w-5 text-slate-400 group-hover:text-slate-500" />
                    Sair
                </button>
            </form>
        </div>
    </nav>
</div>
