<div class="p-4 md:p-6" x-data="{
    canvas: null,
    ctx: null,
    drawing: false,
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
        <div class="mt-6">
            <a href="{{ route('workspace.show', $diary->school_class_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Voltar à turma</a>
        </div>
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
