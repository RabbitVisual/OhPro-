<?php

namespace Modules\ClassRecord\Enums;

enum PdfTheme: string
{
    case CLASSIC = 'classic';
    case MODERN = 'modern';
    case COMPACT = 'compact';

    public function label(): string
    {
        return match ($this) {
            self::CLASSIC => 'Clássico (Padrão)',
            self::MODERN => 'Moderno (Clean)',
            self::COMPACT => 'Compacto (Lista)',
        };
    }

    public function classes(): array
    {
        return match ($this) {
            self::CLASSIC => [
                'bg' => 'bg-white',
                'text' => 'text-gray-900',
                'border' => 'border-gray-300',
                'header_bg' => 'bg-gray-100',
            ],
            self::MODERN => [
                'bg' => 'bg-white',
                'text' => 'font-sans text-slate-800',
                'border' => 'border-slate-100',
                'header_bg' => 'bg-transparent',
            ],
            self::COMPACT => [
                'bg' => 'bg-white',
                'text' => 'text-xs text-gray-900',
                'border' => 'border-gray-400',
                'header_bg' => 'bg-gray-200',
            ],
        };
    }
}
