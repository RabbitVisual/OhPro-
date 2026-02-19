<div>
    <x-modal wire:model="modalOpen" max-width="md">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Avaliar Item</h2>

            @if($item)
                <div class="flex items-center gap-3 mb-6">
                     <img src="{{ $item->preview_url }}" class="w-12 h-12 rounded object-cover bg-gray-100">
                     <div class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item->title }}</div>
                </div>
            @endif

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sua Nota</label>
                <div class="flex gap-2">
                    @foreach(range(1, 5) as $star)
                        <button type="button" wire:click="$set('rating', {{ $star }})" class="focus:outline-none transition-transform hover:scale-110">
                            <x-icon
                                name="star"
                                style="{{ $star <= $rating ? 'solid' : 'regular' }}"
                                class="{{ $star <= $rating ? 'text-yellow-400' : 'text-gray-300' }} text-2xl"
                            />
                        </button>
                    @endforeach
                </div>
                @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comentário (Opcional)</label>
                <textarea
                    wire:model="comment"
                    rows="4"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="O que você achou deste material?"
                ></textarea>
                @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button wire:click="$set('modalOpen', false)" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800 rounded-lg">
                    Cancelar
                </button>
                <button wire:click="save" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                    Enviar Avaliação
                </button>
            </div>
        </div>
    </x-modal>
</div>
