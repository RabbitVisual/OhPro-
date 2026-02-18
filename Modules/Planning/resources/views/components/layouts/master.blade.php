<x-layouts.app :title="($title ?? 'Planning') . ' - ' . config('app.name')">
    {{ $slot }}
</x-layouts.app>
