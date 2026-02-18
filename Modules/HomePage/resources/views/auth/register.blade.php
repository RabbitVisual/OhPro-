<x-layouts.guest title="Criar Conta — Oh Pro!">
    <div class="flex min-h-screen bg-white dark:bg-slate-950">
        <!-- Left Side: Branding & Info (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-purple-600 dark:bg-purple-900 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-white/10 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-950/20 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="relative z-10 w-full flex flex-col justify-between p-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-10 w-10 brightness-0 invert shadow-lg transition-transform group-hover:scale-110" alt="Logo">
                    <span class="text-3xl font-display font-bold text-white tracking-tight">Oh Pro!</span>
                </a>

                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 text-white font-medium text-sm backdrop-blur-md border border-white/20">
                         <x-icon name="rocket-launch" style="duotone" />
                         <span>Inicie sua jornada hoje</span>
                    </div>
                    <h2 class="text-5xl font-display font-bold text-white leading-tight">
                        A liberdade que você <br> precisa para ensinar.
                    </h2>
                    <p class="text-xl text-purple-100 leading-relaxed max-w-lg">
                        Crie sua conta em poucos segundos e descubra como a nossa tecnologia pode potencializar sua didática e organizar seu tempo.
                    </p>
                </div>

                <div class="flex items-center justify-between text-purple-100/60 text-sm">
                    <p>© 2026 Vertex Solutions LTDA.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Termos</a>
                        <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacidade</a>
                        <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Ajuda</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24 overflow-y-auto">
            <div class="w-full max-w-xl space-y-10" x-data="{
                step: 1,
                form: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    cpf: '',
                    phone: '',
                    birth_date: '',
                    password: '',
                    password_confirmation: '',
                    terms: false
                },
                errors: {},
                validateStep(currentStep) {
                    this.errors = {};
                    let isValid = true;

                    if (currentStep === 1) {
                        if (!this.form.first_name) { this.errors.first_name = 'O nome é obrigatório.'; isValid = false; }
                        if (!this.form.last_name) { this.errors.last_name = 'O sobrenome é obrigatório.'; isValid = false; }
                        if (!this.form.email) { this.errors.email = 'O e-mail é obrigatório.'; isValid = false; }
                        if (!this.form.cpf) { this.errors.cpf = 'O CPF é obrigatório.'; isValid = false; }
                    }

                    if (currentStep === 2) {
                        if (!this.form.phone) { this.errors.phone = 'O telefone é obrigatório.'; isValid = false; }
                        if (!this.form.birth_date) { this.errors.birth_date = 'A data de nascimento é obrigatória.'; isValid = false; }
                    }

                    if (isValid) {
                        this.step++;
                    }
                }
            }">
                <!-- Mobile Header -->
                <div class="lg:hidden flex justify-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('storage/logo/favicon.svg') }}" class="h-12 w-12" alt="Logo">
                        <span class="text-2xl font-display font-bold text-purple-600 dark:text-purple-400">Oh Pro!</span>
                    </a>
                </div>

                <!-- Header -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white">Criar sua conta</h1>
                        <span class="text-sm font-bold text-slate-400">Passo <span x-text="step" class="text-purple-600 dark:text-purple-400"></span> de 3</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-600 transition-all duration-500" :style="'width: ' + (step * 33.33) + '%'"></div>
                    </div>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Step 1: Personal Data -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="first_name" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nome</label>
                                <input type="text" id="first_name" name="first_name" :required="step === 1" x-model="form.first_name" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="Seu nome">
                                <span x-show="errors.first_name" x-text="errors.first_name" class="text-red-500 text-sm font-bold"></span>
                                @error('first_name') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="last_name" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Sobrenome</label>
                                <input type="text" id="last_name" name="last_name" :required="step === 1" x-model="form.last_name" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="Seu sobrenome">
                                <span x-show="errors.last_name" x-text="errors.last_name" class="text-red-500 text-sm font-bold"></span>
                                @error('last_name') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-full space-y-2">
                                <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300">E-mail</label>
                                <input type="email" id="email" name="email" :required="step === 1" x-model="form.email" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="seu@email.com">
                                <span x-show="errors.email" x-text="errors.email" class="text-red-500 text-sm font-bold"></span>
                                @error('email') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-full space-y-2">
                                <label for="cpf" class="block text-sm font-bold text-slate-700 dark:text-slate-300">CPF</label>
                                <input type="text" id="cpf" name="cpf" :required="step === 1" x-mask="'cpf'" x-model="form.cpf" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="000.000.000-00">
                                <span x-show="errors.cpf" x-text="errors.cpf" class="text-red-500 text-sm font-bold"></span>
                                @error('cpf') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Contact/Complementary -->
                    <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="col-span-full space-y-2">
                                <label for="phone" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Telefone / WhatsApp</label>
                                <input type="text" id="phone" name="phone" :required="step === 2" x-mask="'phone'" x-model="form.phone" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="(00) 00000-0000">
                                <span x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-sm font-bold"></span>
                                @error('phone') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-full space-y-2">
                                <label for="birth_date" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Data de Nascimento</label>
                                <input type="text" id="birth_date" name="birth_date" :required="step === 2" x-mask="'date'" x-model="form.birth_date" @keydown.enter.prevent="validateStep(step)"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="DD/MM/AAAA">
                                <span x-show="errors.birth_date" x-text="errors.birth_date" class="text-red-500 text-sm font-bold"></span>
                                @error('birth_date') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Security -->
                    <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Crie uma Senha</label>
                                <input type="password" id="password" name="password" :required="step === 3" x-model="form.password"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="Mínimo 8 caracteres">
                                @error('password') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Confirme a Senha</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" :required="step === 3" x-model="form.password_confirmation"
                                       class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 transition-all outline-none"
                                       placeholder="Repita sua senha">
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800">
                                <input type="checkbox" id="terms" name="terms" :required="step === 3" x-model="form.terms" class="mt-1 w-5 h-5 rounded border-slate-200 dark:border-slate-800 text-purple-600 focus:ring-purple-500/20 bg-white dark:bg-slate-950 transition-all">
                                <label for="terms" class="text-sm text-slate-600 dark:text-slate-400">
                                    Eu li e concordo com os <a href="{{ route('terms') }}" target="_blank" class="font-bold text-purple-600 dark:text-purple-400 hover:underline">Termos de Uso</a> e a <a href="{{ route('privacy') }}" target="_blank" class="font-bold text-purple-600 dark:text-purple-400 hover:underline">Política de Privacidade</a>.
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="button" x-show="step > 1" @click="step--"
                                class="px-8 py-5 bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 rounded-2xl font-bold transition-all hover:bg-slate-200 dark:hover:bg-slate-800">
                            Voltar
                        </button>

                        <button type="button" x-show="step < 3" @click="validateStep(step)"
                                class="flex-1 py-5 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-purple-100 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                            Continuar
                            <x-icon name="arrow-right" style="duotone" class="text-sm" />
                        </button>

                        <button type="submit" x-show="step === 3"
                                class="flex-1 py-5 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-purple-100 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                            Finalizar Registro
                            <x-icon name="check" style="duotone" class="text-sm" />
                        </button>
                    </div>
                </form>

                <div class="pt-8 text-center sm:text-left">
                    <p class="text-slate-600 dark:text-slate-400">
                        Já possui uma conta?
                        <a href="{{ route('login') }}" class="font-bold text-purple-600 dark:text-purple-400 hover:text-purple-700 underline underline-offset-4 decoration-2">Fazer Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
