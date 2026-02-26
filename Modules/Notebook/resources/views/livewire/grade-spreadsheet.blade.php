<div class="w-full p-4 md:p-6" x-data="{
    queueKey: 'gradeQueue_{{ $schoolClassId }}_{{ $cycle }}',
    shareModalOpen: false,
    sharePhone: '',
    shareError: null,
    shareLoading: false,
    emailModalOpen: false,
    emailTo: '',
    emailError: null,
    emailSuccess: null,
    emailLoading: false,
    async sendEmail() {
        this.emailError = null;
        this.emailSuccess = null;
        if (!this.emailTo || !this.emailTo.includes('@')) {
            this.emailError = 'Informe um e-mail válido.';
            return;
        }
        this.emailLoading = true;
        const cycle = document.getElementById('cycle') ? document.getElementById('cycle').value : '1';
        try {
            const res = await fetch('{{ route('connect.send-email') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ type: 'report_card', email: this.emailTo, school_class_id: {{ $schoolClassId }}, cycle: parseInt(cycle, 10) || 1, _token: '{{ csrf_token() }}' })
            });
            const data = await res.json();
            if (!res.ok) { this.emailError = data.message || 'Não foi possível enviar.'; return; }
            this.emailSuccess = 'E-mail enviado com sucesso.';
            setTimeout(() => { this.emailModalOpen = false; this.emailSuccess = null; }, 1500);
        } catch (e) {
            this.emailError = 'Erro de conexão. Tente novamente.';
        } finally {
            this.emailLoading = false;
        }
    },
    async openWhatsApp() {
        this.shareError = null;
        if (!this.sharePhone || this.sharePhone.replace(/\D/g,'').length < 10) {
            this.shareError = 'Informe um número com DDD.';
            return;
        }
        this.shareLoading = true;
        const cycle = document.getElementById('cycle') ? document.getElementById('cycle').value : '1';
        try {
            const res = await fetch('{{ route('connect.report-card.share', ['schoolClass' => $schoolClassId]) }}?cycle=' + cycle, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (!res.ok) { this.shareError = data.message || 'Não foi possível gerar o link.'; return; }
            const clean = '55' + this.sharePhone.replace(/\D/g,'').replace(/^0/, '');
            const text = encodeURIComponent(data.message);
            window.open('https://wa.me/' + clean + '?text=' + text, '_blank');
            this.shareModalOpen = false;
        } catch (e) {
            this.shareError = 'Erro de conexão. Tente novamente.';
        } finally {
            this.shareLoading = false;
        }
    },
    getPending() {
        try { return JSON.parse(localStorage.getItem(this.queueKey) || '[]'); } catch(e) { return []; }
    },
    setPending(items) {
        localStorage.setItem(this.queueKey, JSON.stringify(items));
    },
    saveOrQueue(studentId, evaluationType, value) {
        if (navigator.onLine) {
            $wire.saveGrade(studentId, evaluationType, value);
        } else {
            const pending = this.getPending();
            const idx = pending.findIndex(p => p.student_id === studentId && p.evaluation_type === evaluationType);
            const item = { student_id: studentId, evaluation_type: evaluationType, value: value === '' ? null : value };
            if (idx >= 0) pending[idx] = item; else pending.push(item);
            this.setPending(pending);
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Será sincronizado ao reconectar.', type: 'info' } }));
        }
    },
    syncPending() {
        const pending = this.getPending();
        if (pending.length === 0) return;
        $wire.syncGrades(pending);
        this.setPending([]);
    }
}" x-init="
    window.addEventListener('online', () => { $nextTick(() => syncPending()); });
")
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="table-list" style="duotone" />
            Notas
        </h1>
        <div class="flex items-center gap-3 flex-wrap">
            <div class="flex items-center gap-2">
                <label for="cycle" class="text-sm text-gray-600 dark:text-gray-400">Ciclo:</label>
                <select id="cycle" wire:model.live="cycle" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                    @for ($c = 1; $c <= 4; $c++)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endfor
                </select>
            </div>
            @if(auth()->user()->isPro())
            <a href="{{ route('notebook.report-card.pdf', ['schoolClass' => $schoolClassId, 'cycle' => $cycle]) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="file-pdf" style="duotone" class="fa-sm" />
                Gerar boletim (PDF)
            </a>
            <button type="button" @click="shareModalOpen = true; shareError = null; sharePhone = ''"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                <x-icon name="whatsapp" style="brands" class="fa-sm" />
                Enviar relatório
            </button>
            <button type="button" @click="emailModalOpen = true; emailError = null; emailTo = ''"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="envelope" style="duotone" class="fa-sm" />
                Enviar por e-mail
            </button>
            @else
            <x-feature-locked feature="Gerar boletim (PDF)" />
            @endif
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="shareModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="shareModalOpen = false">
            <div x-show="shareModalOpen" x-transition @click.outside="shareModalOpen = false"
                 class="w-full max-w-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl p-6">
                <h3 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-2">Enviar boletim via WhatsApp</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Informe o número do destinatário (com DDD). O link do PDF será incluído na mensagem.</p>
                <input type="text" x-model="sharePhone" x-mask="'phone'" placeholder="(00) 00000-0000"
                       class="mb-2 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">
                <p x-show="shareError" x-text="shareError" class="text-sm text-red-600 dark:text-red-400 mb-2"></p>
                <div class="flex gap-2 justify-end mt-4">
                    <button type="button" @click="shareModalOpen = false" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Cancelar</button>
                    <button type="button" @click="openWhatsApp()" :disabled="shareLoading"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white font-medium hover:bg-green-700 disabled:opacity-50">
                        <x-icon name="whatsapp" style="brands" class="fa-sm" />
                        Abrir WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </template>
    <template x-teleport="body">
        <div x-show="emailModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="emailModalOpen = false">
            <div x-show="emailModalOpen" x-transition @click.outside="emailModalOpen = false"
                 class="w-full max-w-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl p-6">
                <h3 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-2">Enviar boletim por e-mail</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Informe o e-mail do destinatário (ex.: coordenador). O PDF será anexado.</p>
                <input type="email" x-model="emailTo" placeholder="email@escola.com"
                       class="mb-2 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm">
                <p x-show="emailError" x-text="emailError" class="text-sm text-red-600 dark:text-red-400 mb-2"></p>
                <p x-show="emailSuccess" x-text="emailSuccess" class="text-sm text-green-600 dark:text-green-400 mb-2"></p>
                <div class="flex gap-2 justify-end mt-4">
                    <button type="button" @click="emailModalOpen = false" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Cancelar</button>
                    <button type="button" @click="sendEmail()" :disabled="emailLoading"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 disabled:opacity-50">
                        <x-icon name="envelope" style="duotone" class="fa-sm" />
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </template>

    @if($rubricModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" wire:key="rubric-modal">
        <div class="w-full max-w-md max-h-[90vh] overflow-y-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl p-6">
            <h3 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-1">Nota por rubrica</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $rubricModalStudentName }} — {{ strtoupper($rubricModalEvaluationType) }}</p>
            @if(count($this->rubrics) > 0)
            <form wire:submit="saveGradeFromRubric" class="space-y-4">
                @foreach($this->rubrics as $rubric)
                <div>
                    <label for="rubric-{{ $rubric->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $rubric->name }}</label>
                    <select id="rubric-{{ $rubric->id }}" wire:model="rubricModalSelections.{{ $rubric->id }}"
                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2.5 min-h-[44px] touch-manipulation">
                        <option value="">— Selecionar nível —</option>
                        @foreach($rubric->levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}@if($level->points !== null) ({{ number_format($level->points, 1, ',', '') }})@endif</option>
                        @endforeach
                    </select>
                </div>
                @endforeach
                <div class="flex gap-2 justify-end pt-2">
                    <button type="button" wire:click="$set('rubricModalOpen', false)" class="px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 min-h-[44px] touch-manipulation">Cancelar</button>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 min-h-[44px] touch-manipulation">
                        <x-icon name="calculator" style="duotone" class="fa-sm" />
                        Calcular e salvar
                    </button>
                </div>
            </form>
            @else
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Crie rubricas e níveis na página de Rubricas para usar esta função.</p>
            <a href="{{ route('notebook.rubrics.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">Ir para Rubricas</a>
            <button type="button" wire:click="$set('rubricModalOpen', false)" class="ml-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Fechar</button>
            @endif
        </div>
    </div>
    @endif

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
                            <div class="flex items-center justify-center gap-1">
                                <input type="number" step="0.01" min="0" max="10"
                                    value="{{ $row['av1'] !== null ? $row['av1'] : '' }}"
                                    @blur="saveOrQueue({{ $row['student']->id }}, 'av1', $event.target.value)"
                                    class="w-14 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 touch-manipulation"
                                    placeholder="—"
                                />
                                <button type="button" wire:click="openRubricModal({{ $row['student']->id }}, '{{ addslashes($row['student']->name) }}', 'av1')"
                                    class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 touch-manipulation"
                                    title="Calcular nota por rubrica">
                                    <x-icon name="calculator" style="duotone" class="fa-sm" />
                                </button>
                            </div>
                        </td>
                        <td class="px-2 py-2">
                            <div class="flex items-center justify-center gap-1">
                                <input type="number" step="0.01" min="0" max="10"
                                    value="{{ $row['av2'] !== null ? $row['av2'] : '' }}"
                                    @blur="saveOrQueue({{ $row['student']->id }}, 'av2', $event.target.value)"
                                    class="w-14 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 touch-manipulation"
                                    placeholder="—"
                                />
                                <button type="button" wire:click="openRubricModal({{ $row['student']->id }}, '{{ addslashes($row['student']->name) }}', 'av2')"
                                    class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 touch-manipulation"
                                    title="Calcular nota por rubrica">
                                    <x-icon name="calculator" style="duotone" class="fa-sm" />
                                </button>
                            </div>
                        </td>
                        <td class="px-2 py-2">
                            <div class="flex items-center justify-center gap-1">
                                <input type="number" step="0.01" min="0" max="10"
                                    value="{{ $row['av3'] !== null ? $row['av3'] : '' }}"
                                    @blur="saveOrQueue({{ $row['student']->id }}, 'av3', $event.target.value)"
                                    class="w-14 min-h-[44px] text-center rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 touch-manipulation"
                                    placeholder="—"
                                />
                                <button type="button" wire:click="openRubricModal({{ $row['student']->id }}, '{{ addslashes($row['student']->name) }}', 'av3')"
                                    class="min-h-[44px] min-w-[44px] flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 touch-manipulation"
                                    title="Calcular nota por rubrica">
                                    <x-icon name="calculator" style="duotone" class="fa-sm" />
                                </button>
                            </div>
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
