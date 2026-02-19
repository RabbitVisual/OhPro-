<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartões de Acesso - {{ $schoolClass->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { margin: 0.5cm; }
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
        .card {
            width: 8.5cm;
            height: 5.4cm; /* standard business card size approx */
            border: 1px dashed #ccc;
            page-break-inside: avoid;
        }
    </style>
</head>
<body class="bg-gray-100 p-8 print:p-0 print:bg-white">
    <div class="max-w-4xl mx-auto print:w-full">
        <div class="flex justify-between items-center mb-8 no-print">
            <h1 class="text-2xl font-bold text-gray-800">Cartões de Acesso: {{ $schoolClass->name }}</h1>
            <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                Imprimir
            </button>
        </div>

        <div class="grid grid-cols-2 gap-4 print:grid-cols-2 print:gap-2">
            @foreach($students as $student)
                <div class="card bg-white p-4 flex items-center justify-between rounded-lg shadow-sm print:shadow-none print:border print:border-gray-300">
                    <div class="flex-1 pr-4">
                        <h2 class="font-bold text-lg leading-tight mb-1">{{ $student->name }}</h2>
                        <p class="text-xs text-gray-500 mb-2">ID: {{ $student->identifier ?? $student->id }}</p>
                        <div class="text-[10px] text-gray-400 uppercase tracking-wider">{{ config('app.name') }} Pass</div>
                    </div>
                    <div class="flex-shrink-0">
                        {!! QrCode::size(100)->generate($student->qr_data) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
