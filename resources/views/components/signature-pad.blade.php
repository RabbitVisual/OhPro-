@props([
    'name' => 'signature',
    'width' => 400,
    'height' => 200,
])

<div
    x-data="{
        canvas: null,
        ctx: null,
        drawing: false,
        name: @js($name),
        init() {
            this.$nextTick(() => {
                this.canvas = this.$refs.canvas;
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
        clear() {
            if (!this.ctx || !this.canvas) return;
            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        },
        getDataUrl() {
            if (!this.canvas) return null;
            return this.canvas.toDataURL('image/png');
        }
    }"
    {{ $attributes->merge(['class' => '']) }}
>
    <canvas
        x-ref="canvas"
        width="{{ $width }}"
        height="{{ $height }}"
        class="border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 touch-none w-full"
        style="max-width: 100%;"
    ></canvas>
    <div class="mt-2 flex gap-2">
        <button type="button" @click="clear()" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
            Limpar
        </button>
    </div>
</div>
