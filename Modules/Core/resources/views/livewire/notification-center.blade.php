<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    {{-- Bell Icon --}}
    <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
        <x-icon name="bell" style="duotone" class="w-6 h-6" />

        @if($unreadCount > 0)
            <span class="absolute top-1 right-1 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 z-50 overflow-hidden"
         style="display: none;">

        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700/50">
            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notificações</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                    Marcar todas como lidas
                </button>
            @endif
        </div>

        <div class="max-h-[400px] overflow-y-auto">
            @forelse($this->notifications as $notification)
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ $notification->read_at ? 'opacity-75' : 'bg-indigo-50/30 dark:bg-indigo-900/10' }}">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            @if(isset($notification->data['icon']))
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                                    <x-icon :name="$notification->data['icon']" style="duotone" class="fa-sm" />
                                </div>
                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'alert')
                                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-600 dark:text-red-300">
                                    <x-icon name="circle-exclamation" style="duotone" class="fa-sm" />
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                                    <x-icon name="bell" style="duotone" class="fa-sm" />
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $notification->data['title'] ?? 'Nova Notificação' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @if(!$notification->read_at)
                            <button wire:click="markAsRead('{{ $notification->id }}')" class="text-gray-400 hover:text-indigo-600" title="Marcar como lida">
                                <x-icon name="check" class="w-3 h-3" />
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="w-12 h-12 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 mb-3">
                        <x-icon name="bell-slash" style="duotone" class="w-5 h-5" />
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma notificação nova.</p>
                </div>
            @endforelse
        </div>

        <div class="px-4 py-2 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 text-center">
             {{-- Could link to a full notifications page --}}
             <span class="text-xs text-gray-400">Últimas 10 notificações</span>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('play-notification-sound', () => {
                const audio = new Audio('https://actions.google.com/sounds/v1/cartoon/pop.ogg');
                audio.volume = 0.5;
                audio.play().catch(e => console.log('Audio error:', e));
            });
        });
    </script>
</div>
