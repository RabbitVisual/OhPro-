<div class="p-4 md:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="table-list" style="duotone" />
            Notas
        </h1>
        <div class="flex items-center gap-2">
            <label for="cycle" class="text-sm text-gray-600 dark:text-gray-400">Ciclo:</label>
            <select id="cycle" wire:model.live="cycle" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                @for ($c = 1; $c <= 4; $c++)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase sticky left-0 bg-gray-50 dark:bg-gray-900 z-10 min-w-[140px]">Aluno</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase min-w-[90px]">Av1</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase min-w-[90px]">Av2</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase min-w-[90px]">Av3</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase min-w-[90px]">Média</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($rows as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white sticky left-0 bg-white dark:bg-gray-800 z-10">
                            {{ $row['student']->name }}
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" step="0.01" min="0" max="10"
                                value="{{ $row['av1'] !== null ? $row['av1'] : '' }}"
                                @blur="$wire.saveGrade({{ $row['student']->id }}, 'av1', $event.target.value)"
                                class="w-16 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 mx-auto block touch-manipulation"
                                placeholder="—"
                            />
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" step="0.01" min="0" max="10"
                                value="{{ $row['av2'] !== null ? $row['av2'] : '' }}"
                                @blur="$wire.saveGrade({{ $row['student']->id }}, 'av2', $event.target.value)"
                                class="w-16 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 mx-auto block touch-manipulation"
                                placeholder="—"
                            />
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" step="0.01" min="0" max="10"
                                value="{{ $row['av3'] !== null ? $row['av3'] : '' }}"
                                @blur="$wire.saveGrade({{ $row['student']->id }}, 'av3', $event.target.value)"
                                class="w-16 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 mx-auto block touch-manipulation"
                                placeholder="—"
                            />
                        </td>
                        <td class="px-4 py-3 text-sm text-center text-gray-700 dark:text-gray-300 font-medium">
                            {{ $row['average'] !== null ? number_format($row['average'], 1, ',', '') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Nenhum aluno na turma. Adicione alunos à turma primeiro.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
