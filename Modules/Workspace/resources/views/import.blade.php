<x-workspace::layouts.master>
    <div class="min-h-screen p-4 md:p-6">
        <div class="mb-6">
            <a href="{{ route('workspace.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar ao workspace
            </a>
        </div>
        <livewire:classrecord.student-import />
    </div>
</x-workspace::layouts.master>
