<div x-data="{ open: @entangle('modalOpen') }"
     x-show="open"
     x-on:keydown.escape.window="open = false"
     class="relative z-50"
     style="display: none;">

    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                {{-- Header --}}
                <div class="bg-indigo-600 px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold leading-6 text-white flex items-center gap-2">
                            <i class="fa-duotone fa-shop mr-2"></i>
                            Vender na Loja
                        </h3>
                        <button type="button" @click="open = false" class="text-indigo-200 hover:text-white transition-colors">
                            <i class="fa-solid fa-xmark fa-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <form wire:submit="save">

                        {{-- Title --}}
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                Título do Produto
                            </label>
                            <div class="mt-2">
                                <input type="text" wire:model="title" id="title"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-700 dark:text-white dark:ring-gray-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Price --}}
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                Preço (R$)
                            </label>
                            <div class="mt-2 relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <span class="text-gray-500 sm:text-sm">R$</span>
                                </div>
                                <input type="number" step="0.01" wire:model="price" id="price"
                                    class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-700 dark:text-white dark:ring-gray-600 sm:text-sm sm:leading-6"
                                    placeholder="0.00">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">A plataforma retém 20% de taxa administrativa.</p>
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                Descrição do Produto
                            </label>
                            <div class="mt-2">
                                <textarea wire:model="description" id="description" rows="4"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:bg-gray-700 dark:text-white dark:ring-gray-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2">
                                <i class="fa-duotone fa-shop mr-2"></i>
                                Publicar
                            </button>
                            <button type="button" @click="open = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0 dark:bg-gray-700 dark:text-white dark:ring-gray-600 dark:hover:bg-gray-600">
                                Cancelar
                            </button>
                        </div>
                    </form>

                    @if($isPublished)
                    <div class="mt-4 border-t pt-4 border-gray-200 dark:border-gray-700">
                        <button wire:click="unpublish" type="button" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 w-full text-center">
                            Remover da Loja (Despublicar)
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
