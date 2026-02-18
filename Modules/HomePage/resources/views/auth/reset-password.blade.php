<x-layouts.guest title="Redefinir Senha — Oh Pro!">
    <div class="flex min-h-screen bg-white dark:bg-slate-950">
        <!-- Left Side (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-indigo-800 overflow-hidden">
             <!-- Background Decoration -->
             <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            </div>

            <div class="relative z-10 w-full flex flex-col justify-center p-16 text-white text-center">
                <div class="w-24 h-24 rounded-3xl bg-white/10 flex items-center justify-center border border-white/20 mx-auto mb-10 shadow-2xl">
                     <x-icon :name="config('icon.auth.shield', 'shield-lock')" style="duotone" size="4xl" class="text-white" />
                </div>
                <h2 class="text-5xl font-display font-bold leading-tight mb-6">
                    Segurança em <br> Primeiro Lugar.
                </h2>
                <p class="text-xl text-indigo-100 leading-relaxed max-w-md mx-auto">
                    Escolha uma senha forte e única para garantir que seus dados e planejamentos continuem protegidos.
                </p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 lg:p-24">
            <div class="w-full max-w-md space-y-10">
                <div class="space-y-4">
                    <h1 class="text-3xl font-display font-bold text-slate-900 dark:text-white">Redefinir Senha</h1>
                    <p class="text-slate-600 dark:text-slate-400">Insira sua nova senha abaixo.</p>
                </div>

                <form action="{{ route('password.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300">E-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                               class="block w-full px-4 py-4 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-500 dark:text-slate-400 cursor-not-allowed outline-none">
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Nova Senha</label>
                        <input type="password" id="password" name="password" required autofocus
                               class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                               placeholder="Mínimo 8 caracteres">
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-300">Confirmar Nova Senha</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="block w-full px-4 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none"
                               placeholder="Repita sua nova senha">
                    </div>

                    <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-100 dark:shadow-none transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center gap-2">
                        Atualizar Senha
                        <x-icon name="check-to-slot" style="duotone" class="text-sm" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.guest>
