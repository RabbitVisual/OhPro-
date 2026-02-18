<x-layouts.app :title="'Chamada - ' . ($schoolClass->name ?? config('app.name'))">
    <livewire:notebook.quick-attendance :schoolClassId="$schoolClass->id" :date="request()->get('date', now()->format('Y-m-d'))" />
</x-layouts.app>
