<x-layouts.app :title="'Notas - ' . ($schoolClass->name ?? config('app.name'))">
    <livewire:notebook.grade-spreadsheet :schoolClassId="$schoolClass->id" :cycle="request()->integer('cycle', 1)" />
</x-layouts.app>
