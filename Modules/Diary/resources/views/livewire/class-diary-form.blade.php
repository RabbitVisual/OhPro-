<div class="w-full p-4 md:p-6" x-data="{
    canvas: null,
    ctx: null,
    drawing: false,
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
        try {
            const res = await fetch('{{ route('connect.send-email') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ type: 'diary', email: this.emailTo, diary_id: {{ $diary->id }}, _token: '{{ csrf_token() }}' })
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
        try {
            const res = await fetch('{{ route('connect.diary.share', $diary) }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
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
    init() {
        this.$nextTick(() => {
            this.canvas = this.$refs.sigCanvas;
            if (!this.canvas) return;
            this.ctx = this.canvas.getContext('2d');
            this.ctx.strokeStyle = '#000';
            this.ctx.lineWidth = 2;
            this.ctx.lineCap = 'round';
            const rect = this.canvas.getBoundingClientRect();
            const scaleX = this.canvas.width / rect.width;
            const scaleY = this.canvas.height / rect.height;
            this.canvas.addEventListener('pointerdown', (e) => {
                this.drawing = true;
                const x = (e.clientX - rect.left) * scaleX;
                const y = (e.clientY - rect.top) * scaleY;
                this.ctx.beginPath();
                this.ctx.moveTo(x, y);
            });
            this.canvas.addEventListener('pointermove', (e) => {
                if (!this.drawing) return;
                const x = (e.clientX - rect.left) * scaleX;
                const y = (e.clientY - rect.top) * scaleY;
                this.ctx.lineTo(x, y);
                this.ctx.stroke();
            });
            this.canvas.addEventListener('pointerup', () => { this.drawing = false; });
            this.canvas.addEventListener('pointerleave', () => { this.drawing = false; });
        });
    },
    clearSig() {
        if (!this.ctx || !this.canvas) return;
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    getDataUrl() {
        return this.canvas ? this.canvas.toDataURL('image/png') : '';
    },
    doFinalize() {
        const url = this.getDataUrl();
        if (!url || url.length < 100) {
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Assine antes de finalizar.', type: 'error' } }));
            return;
        }
        $wire.finalize(url);
    }
}">
    <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <x-icon name="book-bookmark" style="duotone" />
        Registro de aula
    </h1>

    @if($diary->is_finalized)
        <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4 text-green-800 dark:text-green-200">
            <p class="font-medium">Este registro foi finalizado em {{ $diary->ended_at?->translatedFormat('d/m/Y H:i') }}.</p>
        </div>
        @if($diary->content)
            <div class="mt-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $diary->content['title'] ?? 'Plano aplicado' }}</h2>
                @foreach($diary->content['sections'] ?? [] as $section)
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $section['field_key'] ?? '' }}</span>
                        <p class="text-gray-900 dark:text-white">{{ $section['value'] ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="mt-6 flex flex-wrap items-center gap-3">
            @if(auth()->user()->isPro())
            <a href="{{ route('diary.class.pdf', $diary) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                <x-icon name="file-pdf" style="duotone" class="fa-sm" />
                Gerar PDF Oficial
            </a>
            <button type="button" @click="shareModalOpen = true; shareError = null; sharePhone = ''"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                <x-icon name="whatsapp" style="brands" class="fa-sm" />
                Enviar via WhatsApp
            </button>
            <button type="button" @click="emailModalOpen = true; emailError = null; emailTo = ''"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                <x-icon name="envelope" style="duotone" class="fa-sm" />
                Enviar por e-mail
            </button>
            @else
            <x-feature-locked feature="Gerar PDF Oficial" />
            @endif
            <a href="{{ route('workspace.show', $diary->school_class_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Voltar à turma</a>
        </div>
        <template x-teleport="body">
            <div x-show="shareModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @keydown.escape.window="shareModalOpen = false">
                <div x-show="shareModalOpen" x-transition @click.outside="shareModalOpen = false"
                     class="w-full max-w-sm rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl p-6">
                    <h3 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-2">Enviar relatório via WhatsApp</h3>
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
                    <h3 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-2">Enviar relatório por e-mail</h3>
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
    @else
        @if($diary->content && !empty($diary->content['sections']))
            <div class="mb-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $diary->content['title'] ?? 'Conteúdo do plano' }}</h2>
                @foreach($diary->content['sections'] ?? [] as $section)
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $section['field_key'] ?? '' }}</span>
                        <p class="text-gray-900 dark:text-white">{{ $section['value'] ?? '—' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Assinatura do professor</h3>
            <canvas
                x-ref="sigCanvas"
                width="400"
                height="200"
                class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 touch-none w-full max-w-md"
            ></canvas>
            <div class="mt-2 flex gap-4">
                <button type="button" @click="clearSig()" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Limpar</button>
                <button type="button" @click="doFinalize()" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Finalizar registro
                </button>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('workspace.show', $diary->school_class_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Voltar à turma</a>
        </div>
    @endif
</div>
