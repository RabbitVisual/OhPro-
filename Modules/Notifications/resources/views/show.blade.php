<x-layouts.app-sidebar title="Notificação — Oh Pro!">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('notifications.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:underline flex items-center gap-1 mb-6 w-fit">
            <x-icon name="arrow-left" style="duotone" class="fa-sm" />
            Voltar às Notificações
        </a>

        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ $notification->created_at->translatedFormat('d/m/Y H:i') }}
                </p>
                <h1 class="text-xl font-display font-bold text-slate-900 dark:text-white mt-1">
                    {{ is_array($notification->data) && isset($notification->data['title']) ? $notification->data['title'] : 'Notificação' }}
                </h1>
            </div>
            <div class="p-6">
                @if(is_array($notification->data))
                    @if(!empty($notification->data['message']))
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $notification->data['message'] }}</p>
                    @elseif(!empty($notification->data['body']))
                        <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $notification->data['body'] }}</p>
                    @else
                        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            @foreach($notification->data as $key => $value)
                                @if(!in_array($key, ['title', 'message', 'body']) && is_scalar($value))
                                    <p><span class="font-medium text-slate-500">{{ ucfirst($key) }}:</span> {{ $value }}</p>
                                @endif
                            @endforeach
                        </div>
                        @if(empty(array_diff_key($notification->data, array_flip(['title', 'message', 'body']))))
                            <p class="text-slate-500 dark:text-slate-400">Sem conteúdo adicional.</p>
                        @endif
                    @endif
                @else
                    <p class="text-slate-500 dark:text-slate-400">Conteúdo indisponível.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
