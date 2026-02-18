<x-layouts.app title="Perfil - Marca pessoal">
    <div class="min-h-screen p-4 md:p-6">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar
            </a>
            <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mt-2 flex items-center gap-2">
                <x-icon name="id-card" style="duotone" />
                Marca pessoal
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Logo e assinatura aparecem nos PDFs oficiais (diário e boletim).</p>
        </div>

        @if(session('success'))
            <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
        @endif

        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="max-w-2xl space-y-6">
            @csrf
            @method('PUT')
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Logo / Carimbo</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Usado no cabeçalho dos PDFs. Imagem recomendada: quadrada ou horizontal, até 2 MB.</p>
                @if($logoDataUrl ?? null)
                    <div class="mb-4">
                        <img src="{{ $logoDataUrl }}" alt="Logo atual" class="max-h-20 object-contain" />
                    </div>
                @endif
                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300" />
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Imagem de assinatura</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Usada no diário de classe. Até 1 MB.</p>
                @if($signatureDataUrl ?? null)
                    <div class="mb-4">
                        <img src="{{ $signatureDataUrl }}" alt="Assinatura atual" class="max-h-16 object-contain" />
                    </div>
                @endif
                <input type="file" name="signature" accept="image/*" class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300" />
            </div>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                Salvar
            </button>
        </form>
    </div>
</x-layouts.app>
