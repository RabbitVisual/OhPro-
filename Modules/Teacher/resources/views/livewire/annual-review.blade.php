<div class="p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl relative overflow-hidden">
    {{-- Background Decoration --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

    <div class="relative z-10 mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-display font-bold text-slate-950 dark:text-white">Seu Ano em Dados</h2>
            <p class="text-slate-500 dark:text-slate-400">O impacto que você gerou na educação este ano.</p>
        </div>
        <div class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-bold uppercase tracking-wider">
            2025-2026
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg text-indigo-600 dark:text-indigo-400">
                    <x-icon name="users" style="duotone" class="w-5 h-5" />
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Alunos Impactados</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['total_students'] }}</p>
        </div>

        {{-- Card 2 --}}
        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/50 rounded-lg text-purple-600 dark:text-purple-400">
                    <x-icon name="book-open" style="duotone" class="w-5 h-5" />
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Aulas Planejadas</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['total_plans'] }}</p>
        </div>

        {{-- Card 3 --}}
        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/50 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <x-icon name="chalkboard-teacher" style="duotone" class="w-5 h-5" />
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Aulas Ministradas</span>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['classes_taught'] }}</p>
        </div>
    </div>

    {{-- Chart Section --}}
    <div x-data="{
        initChart() {
            const options = {
                series: [{
                    name: 'Planos Criados',
                    data: [{{ implode(',', array_values($stats['top_skills'])) }}]
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: ['EF09MA01', 'EF08LP04', 'EF07CI03', 'EF09HI02', 'EF06GE01'],
                },
                colors: ['#6366f1'],
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                }
            };

            const chart = new ApexCharts(document.querySelector('#skills-chart'), options);
            chart.render();
        }
    }" x-init="initChart()">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Habilidades da BNCC mais trabalhadas</h3>
        <div id="skills-chart"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</div>
