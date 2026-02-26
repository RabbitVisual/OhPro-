<div class="w-full max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="google" :brand="true" class="text-red-500" />
            Importar do Google Classroom
        </h2>
    </div>

    @if($step === 1)
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Selecione a Turma do Google</h3>
            @if(empty($courses))
                <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg">
                    Nenhuma turma encontrada ou erro na conexão.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($courses as $course)
                        <button wire:click="selectCourse('{{ $course['id'] }}')" class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-500 text-left transition-colors">
                            <h4 class="font-bold text-gray-900 dark:text-white">{{ $course['name'] }}</h4>
                            <p class="text-sm text-gray-500">{{ $course['section'] ?? '' }}</p>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @elseif($step === 2)
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Para qual turma do VertexOh! você quer importar?</h3>
                 <select wire:model="targetClassId" class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    <option value="">Selecione uma turma...</option>
                    @foreach($myClasses as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
                @error('targetClassId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Selecione os Alunos ({{ count($selectedStudents) }})</h3>
                <div class="max-h-96 overflow-y-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" checked disabled class="rounded text-indigo-600">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                            @foreach($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" wire:model.live="selectedStudents" value="{{ $student['id'] }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $student['name'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 @error('selectedStudents') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button wire:click="$set('step', 1)" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Voltar</button>
                <button wire:click="import" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Concluir Importação</button>
            </div>
        </div>
    @endif
</div>
