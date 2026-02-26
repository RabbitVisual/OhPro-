<x-layouts.app-sidebar title="Publicar no Marketplace — Oh Pro!">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('marketplace.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:underline flex items-center gap-1 mb-6 w-fit">
            <x-icon name="arrow-left" style="duotone" class="fa-sm" />
            Voltar ao Marketplace
        </a>

        <header class="mb-8">
            <h1 class="text-2xl font-display font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <x-icon name="plus-circle" style="duotone" class="text-indigo-500" />
                Novo anúncio
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400">
                Crie um anúncio para vender no marketplace. Você também pode publicar a partir da Biblioteca ou do Planejamento (botão &quot;Vender&quot;).
            </p>
        </header>

        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <form action="{{ route('marketplace.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Descrição</label>
                    <textarea name="description" id="description" rows="5" required class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Preço (R$)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Criar rascunho</button>
                    <a href="{{ route('marketplace.index') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app-sidebar>
