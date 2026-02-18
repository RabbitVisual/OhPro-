@extends('classrecord::pdf.layout')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <header class="mb-6 pb-3 border-b border-gray-200 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-display font-bold text-gray-900">Boletim — {{ $schoolClass->name }}</h1>
            <p class="text-sm text-gray-600">{{ $schoolClass->school->name ?? '' }} · Ciclo {{ $cycle }}</p>
        </div>
        @if($logoDataUrl ?? null)
        <img src="{{ $logoDataUrl }}" alt="Logo" class="h-12 w-auto object-contain" />
        @else
        <i class="fa-duotone fa-file-chart-column text-3xl text-indigo-600"></i>
        @endif
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-3 py-2 font-semibold text-gray-700">Aluno</th>
                        <th class="text-center px-3 py-2 font-semibold text-gray-700">Av1</th>
                        <th class="text-center px-3 py-2 font-semibold text-gray-700">Av2</th>
                        <th class="text-center px-3 py-2 font-semibold text-gray-700">Av3</th>
                        <th class="text-center px-3 py-2 font-semibold text-gray-700">Média</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="px-3 py-2 text-gray-900">{{ $row['student']->name }}</td>
                            <td class="px-3 py-2 text-center text-gray-700">{{ $row['av1'] !== null ? number_format($row['av1'], 1, ',', '') : '—' }}</td>
                            <td class="px-3 py-2 text-center text-gray-700">{{ $row['av2'] !== null ? number_format($row['av2'], 1, ',', '') : '—' }}</td>
                            <td class="px-3 py-2 text-center text-gray-700">{{ $row['av3'] !== null ? number_format($row['av3'], 1, ',', '') : '—' }}</td>
                            <td class="px-3 py-2 text-center font-medium text-gray-900">{{ $row['average'] !== null ? number_format($row['average'], 1, ',', '') : '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex flex-col">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Distribuição das médias</h3>
            <div class="flex-1 min-h-[200px]">
                <canvas id="distributionChart" width="280" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var ctx = document.getElementById('distributionChart');
    if (!ctx) return;
    var distribution = @json($distribution);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(distribution),
            datasets: [{
                label: 'Alunos',
                data: Object.values(distribution),
                backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
})();
</script>
@endsection
