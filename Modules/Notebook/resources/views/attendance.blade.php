<x-layouts.app-sidebar :title="'Chamada — ' . ($schoolClass->name ?? 'Oh Pro!')">
    <livewire:notebook.quick-attendance :schoolClassId="$schoolClass->id" :date="request()->get('date', now()->format('Y-m-d'))" />
</x-layouts.app-sidebar>
