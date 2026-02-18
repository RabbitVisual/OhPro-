<x-layouts.app :title="'Gestão escolar - ' . config('app.name')">
    <div class="min-h-screen p-4 md:p-6">
        <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="building" style="duotone" />
            Minhas escolas
        </h1>
        <div class="grid gap-4 max-w-2xl">
            @foreach($schools as $school)
            <a href="{{ route('manager.dashboard', $school) }}" class="block p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <span class="font-display font-bold text-gray-900 dark:text-white">{{ $school->name }}</span>
            </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>
