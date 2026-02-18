<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 mb-6">
    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <x-icon name="calendar-days" style="duotone" />
        Agenda da semana
    </h2>
    @php $dayNames = [1 => 'Seg', 2 => 'Ter', 3 => 'Qua', 4 => 'Qui', 5 => 'Sex']; @endphp
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        @foreach($this->schedulesByDay as $day => $slots)
            <div class="flex flex-col">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">{{ $dayNames[$day] ?? $day }}</h3>
                <div class="space-y-2">
                    @forelse($slots as $schedule)
                        @php
                            $class = $schedule->schoolClass;
                            $school = $class->school;
                            $color = $school && $school->color ? $school->color : '#6366f1';
                        @endphp
                        <a
                            href="{{ $this->attendanceUrl($class) }}"
                            class="block rounded-lg p-2 text-left text-sm border-l-4 hover:opacity-90 transition-opacity"
                            style="border-left-color: {{ $color }}; background-color: {{ $color }}20;"
                        >
                            <span class="font-medium text-gray-900 dark:text-white block truncate">{{ $class->name }}</span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                @if($schedule->end_time)
                                    – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                @endif
                            </span>
                            @if($school)
                                <span class="text-xs text-gray-500 dark:text-gray-500 block truncate">{{ $school->short_name ?? $school->name }}</span>
                            @endif
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 dark:text-gray-500 py-1">—</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
