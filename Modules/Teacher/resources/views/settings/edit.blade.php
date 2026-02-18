<x-layouts.app-sidebar title="Minha Conta">
    <div class="min-h-screen p-4 md:p-6" x-data="{ tab: new URLSearchParams(window.location.search).get('tab') || 'brand' }">
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline flex items-center gap-1">
                <x-icon name="arrow-left" style="duotone" class="fa-sm" />
                Voltar
            </a>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mt-2 flex items-center gap-2">
                <x-icon name="user-circle" style="duotone" />
                Minha Conta
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerencie suas informações pessoais e configurações.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800 flex items-center gap-2">
                <x-icon name="check-circle" class="w-5 h-5" />
                {{ session('success') }}
            </div>
        @endif

        @if(session('status') === 'password-updated')
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800 flex items-center gap-2">
                <x-icon name="check-circle" class="w-5 h-5" />
                Senha atualizada com sucesso.
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sidebar Tabs --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <nav class="space-y-1">
                    <button @click="tab = 'brand'" :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': tab === 'brand', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': tab !== 'brand'}" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <x-icon name="id-card" style="duotone" class="w-5 h-5" />
                        Marca Pessoal
                    </button>
                    <button @click="tab = 'notifications'" :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': tab === 'notifications', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': tab !== 'notifications'}" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <x-icon name="bell" style="duotone" class="w-5 h-5" />
                        Notificações
                    </button>
                    <button @click="tab = 'subscription'" :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': tab === 'subscription', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': tab !== 'subscription'}" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <x-icon name="credit-card" style="duotone" class="w-5 h-5" />
                        Assinatura
                    </button>
                     <button @click="tab = 'security'" :class="{'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white': tab === 'security', 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800': tab !== 'security'}" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors">
                        <x-icon name="shield-check" style="duotone" class="w-5 h-5" />
                        Segurança
                    </button>
                </nav>
            </aside>

            {{-- Content Area --}}
            <div class="flex-1 max-w-2xl">
                {{-- Brand Tab --}}
                <div x-show="tab === 'brand'" x-transition class="space-y-6">
                    <div>
                         <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Marca Pessoal</h2>
                         <p class="text-sm text-gray-500 dark:text-gray-400">Personalize como você aparece nos documentos e relatórios.</p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">Logo / Carimbo</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Usado no cabeçalho dos PDFs. Recomendado: imagem quadrada, até 2 MB.</p>

                            <div class="flex items-center gap-6">
                                @if($logoDataUrl ?? null)
                                    <div class="w-20 h-20 rounded-lg border border-gray-100 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-900/50 p-2">
                                        <img src="{{ $logoDataUrl }}" alt="Logo" class="max-w-full max-h-full object-contain" />
                                    </div>
                                @else
                                    <div class="w-20 h-20 rounded-lg border border-gray-100 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-900/50 text-gray-400">
                                         <x-icon name="image" class="w-8 h-8" />
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition-colors cursor-pointer" />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">Valor da Hora-Aula</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Base para cálculo de receita estimada no painel.</p>
                            <div class="relative max-w-xs">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">R$</span>
                                </div>
                                <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $user->hourly_rate) }}" step="0.01" min="0" max="99999.99" class="pl-10 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" placeholder="0,00" />
                            </div>
                        </div>

                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                             <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">Assinatura Digital</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Usada para validar documentos gerados. Fundo transparente recomendado.</p>

                             <div class="flex items-center gap-6">
                                @if($signatureDataUrl ?? null)
                                    <div class="h-16 px-4 rounded-lg border border-gray-100 dark:border-gray-700 flex items-center justify-center bg-gray-50 dark:bg-gray-900/50">
                                        <img src="{{ $signatureDataUrl }}" alt="Assinatura" class="max-h-full object-contain" />
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" name="signature" accept="image/*" class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition-colors cursor-pointer" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notifications Tab --}}
                <div x-show="tab === 'notifications'" x-transition class="space-y-6" style="display: none;">
                    <div>
                         <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Preferências de Notificação</h2>
                         <p class="text-sm text-gray-500 dark:text-gray-400">Escolha como e quando você quer ser notificado.</p>
                    </div>

                    <form action="{{ route('profile.preferences.update') }}" method="post" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700 overflow-hidden">
                        @csrf
                        @method('PUT')

                        <div class="p-6 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Relatório Semanal</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Receba um resumo do desempenho das turmas toda segunda-feira.</p>
                            </div>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="preferences[weekly_report]" class="sr-only peer" {{ ($user->notification_preferences['weekly_report'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        </div>

                        <div class="p-6 flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Alertas de Frequência</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Seja notificado quando um aluno atingir 25% de faltas.</p>
                            </div>
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="preferences[attendance_alerts]" class="sr-only peer" {{ ($user->notification_preferences['attendance_alerts'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>
                        </div>

                        <div class="p-6 bg-gray-50 dark:bg-gray-700/30 flex justify-end">
                             <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                                Salvar Preferências
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Subscription Tab --}}
                <div x-show="tab === 'subscription'" x-transition class="space-y-6" style="display: none;">
                    <div>
                         <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Sua Assinatura</h2>
                         <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie seu plano e visualize seu uso.</p>
                    </div>

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-6 opacity-10">
                            <x-icon name="crown" class="w-24 h-24 text-indigo-500" />
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium">Plano Atual</h3>
                                @if($user->isPro())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">PRO</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">GRÁTIS</span>
                                @endif
                            </div>

                            <p class="text-3xl font-display font-bold text-gray-900 dark:text-white mb-2">
                                {{ $user->plan()->name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-sm">
                                {{ $user->plan()->description ?? 'Aproveite todos os recursos para potencializar suas aulas.' }}
                            </p>

                             <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700/50">
                                <a href="{{ route('panel.admin.subscriptions') }}" class="text-indigo-600 dark:text-indigo-400 text-sm font-medium hover:underline flex items-center gap-1">
                                    Gerenciar Faturas e Pagamentos
                                    <x-icon name="external-link" class="w-3 h-3" />
                                </a>
                                {{-- NOTE: If Billing module exists and has own route, point there --}}
                            </div>
                        </div>
                    </div>

                    {{-- Usage --}}
                    {{-- Assuming we have access to usage data here. For now static placeholder or simple logic --}}
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                        <h3 class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-medium mb-4">Uso de Recursos (Mês Atual)</h3>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-700 dark:text-gray-300">Gerações de IA</span>
                                    {{-- Placeholder values --}}
                                    <span class="text-gray-900 dark:text-white font-medium">0 / {{ $user->plan()->getLimit('ai_plans_per_month') == -1 ? '∞' : $user->plan()->getLimit('ai_plans_per_month') }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: 5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Security Tab --}}
                <div x-show="tab === 'security'" x-transition class="space-y-6" style="display: none;">
                    <div>
                         <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Segurança</h2>
                         <p class="text-sm text-gray-500 dark:text-gray-400">Proteja sua conta com uma senha forte.</p>
                    </div>

                    <form action="{{ route('profile.password.update') }}" method="post" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha Atual</label>
                            <input type="password" name="current_password" id="current_password" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500" required>
                             @error('current_password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nova Senha</label>
                            <input type="password" name="password" id="password" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500" required>
                             @error('password', 'updatePassword')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                         <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                                Atualizar Senha
                            </button>
                        </div>
                    </form>

                    {{-- 2FA Placeholder --}}
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 opacity-75">
                         <div class="flex items-start gap-4">
                            <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600">
                                <x-icon name="mobile-alt" style="duotone" class="w-6 h-6" />
                            </div>
                            <div>
                                <h3 class="text-base font-medium text-gray-900 dark:text-white">Autenticação em Dois Fatores (2FA)</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Adicione uma camada extra de segurança à sua conta.</p>
                                <button disabled class="mt-3 text-xs font-semibold bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg cursor-not-allowed">
                                    Em breve
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-sidebar>
