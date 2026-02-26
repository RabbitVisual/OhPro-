<x-layouts.app-sidebar :title="'Notas — ' . ($schoolClass->name ?? 'Oh Pro!')">
    <livewire:notebook.grade-spreadsheet :schoolClassId="$schoolClass->id" :cycle="request()->integer('cycle', 1)" />
</x-layouts.app-sidebar>
