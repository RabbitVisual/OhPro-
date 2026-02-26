<x-layouts.app-sidebar title="Notificações — Oh Pro!">
    <div class="max-w-4xl mx-auto">
        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <x-icon name="bell" style="duotone" class="text-indigo-500" />
                Notificações
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">
                Todas as suas notificações em um só lugar.
            </p>
        </header>

        @if($notifications->isEmpty())
            <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-12 text-center">
                <x-icon name="bell-slash" style="duotone" class="w-16 h-16 mx-auto mb-4 text-slate-400" />
                <p class="text-slate-500 dark:text-slate-400">Nenhuma notificação.</p>
                <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline text-sm">Voltar ao início</a>
            </div>
        @else
            <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 overflow-hidden">
                <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($notifications as $notification)
                        @php
                            $data = is_array($notification->data) ? $notification->data : [];
                            $message = $data['message'] ?? $data['title'] ?? class_basename($notification->type);
                        @endphp
                        <li class="hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ $notification->read_at ? '' : 'bg-indigo-50/50 dark:bg-indigo-900/10' }}">
                            <a href="{{ route('notifications.show', $notification->id) }}" class="block px-6 py-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate">
                                            {{ is_string($message) ? Str::limit($message, 80) : 'Notificação' }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                            {{ $notification->created_at->translatedFormat('d/m/Y H:i') }}
                                            @if(!$notification->read_at)
                                                <span class="ml-2 inline-flex w-2 h-2 rounded-full bg-indigo-500"></span>
                                            @endif
                                        </p>
                                    </div>
                                    <x-icon name="chevron-right" style="duotone" class="w-5 h-5 text-slate-400 shrink-0" />
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                    {{ $notifications->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.app-sidebar>
