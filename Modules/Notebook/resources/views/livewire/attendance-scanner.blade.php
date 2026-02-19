<div>
    <x-modal wire:model="modalOpen" max-width="lg">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="qrcode" style="duotone" />
                Scanner de Chamada
            </h2>

            <div class="relative rounded-xl overflow-hidden bg-black aspect-square mb-4">
                <div id="reader" style="width: 100%;"></div>
                <div class="absolute inset-0 pointer-events-none border-2 border-indigo-500/50 rounded-xl"></div>
            </div>

            <div class="text-center">
                @if($lastScannedName)
                    <div class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 p-3 rounded-lg mb-4 animate-pulse">
                        <x-icon name="check-circle" style="solid" />
                        Presença confirmada: <strong>{{ $lastScannedName }}</strong>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Aponte a câmera para o QR Code do aluno.</p>
                @endif
            </div>

            <div class="mt-4 flex justify-end">
                <button wire:click="$set('modalOpen', false)" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Fechar
                </button>
            </div>
        </div>
    </x-modal>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let html5QrcodeScanner = null;

            Livewire.on('open-scanner', () => {
                @this.set('modalOpen', true);

                setTimeout(() => {
                    const readerId = "reader";
                    if (!document.getElementById(readerId)) return;

                    if (html5QrcodeScanner) {
                        // Already running or instantiated?
                        return;
                    }

                    // Use Html5Qrcode class for more control instead of Scanner UI
                    const html5QrCode = new Html5Qrcode(readerId);
                    html5QrcodeScanner = html5QrCode;

                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                    html5QrCode.start({ facingMode: "environment" }, config, (decodedText, decodedResult) => {
                        // Success
                        console.log(`Scan result: ${decodedText}`, decodedResult);
                        @this.call('processScan', decodedText).then(() => {
                             // Optional: pause or show success state
                             // We are handling it in PHP by updating lastScannedName
                             // Maybe delay next scan?
                        });
                    }, (errorMessage) => {
                        // parse error, ignore
                    })
                    .catch(err => {
                        console.log(`Unable to start scanning, error: ${err}`);
                    });
                }, 200); // Wait for modal animation
            });

            @this.on('scan-success', () => {
                // Play success sound
                const audio = new Audio('/assets/sounds/beep.mp3'); // Need to ensure this exists or use a CDN sound
                // Fallback sound if local doesn't exist
                audio.onerror = () => {
                    new Audio('https://actions.google.com/sounds/v1/cartoon/pop.ogg').play();
                };
                audio.play().catch(e => console.log('Audio play failed', e));

                // Visual feedback is handled by Blade (lastScannedName)
            });

            // Stop camera when modal closes
            Livewire.on('close-scanner', () => { // Or watch modalOpen
                 if (html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then((ignore) => {
                        html5QrcodeScanner.clear();
                        html5QrcodeScanner = null;
                    }).catch((err) => {
                        console.log('Failed to stop scanner', err);
                    });
                 }
            });

            // Watch for Livewire updates to modalOpen
            $wire.watch('modalOpen', (value) => {
                if (value === false && html5QrcodeScanner) {
                    html5QrcodeScanner.stop().then(() => {
                        html5QrcodeScanner.clear();
                        html5QrcodeScanner = null;
                    }).catch(err => console.log(err));
                }
            });
        });
    </script>
</div>
