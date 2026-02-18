@props([
    'name',
    'style' => null,
    'class' => '',
    'bordered' => false,
    'pulled' => null, // 'left' or 'right'
    'size' => null, // 'xs', 'sm', 'lg', 'xl', '2xl', etc.
])

@php
    $styleMap = [
        'duotone'       => 'fa-duotone',
        'solid'         => 'fa-solid',
        'regular'       => 'fa-regular',
        'light'         => 'fa-light',
        'brands'        => 'fa-brands',
    ];
    $defaultStyle = config('icon.default_style', 'duotone');
    $resolvedStyle = $style ?? $defaultStyle;
    $faStyle = $styleMap[$resolvedStyle] ?? $styleMap['duotone'];
    $resolvedSize = $size ?? config('icon.default_size');

    $classes = [
        $faStyle,
        "fa-{$name}",
        $bordered ? 'fa-border' : '',
        $pulled ? "fa-pull-{$pulled}" : '',
        $resolvedSize ? "fa-{$resolvedSize}" : '',
        $class
    ];

    $finalClass = implode(' ', array_filter($classes));
@endphp

<i {{ $attributes->merge(['class' => $finalClass]) }} aria-hidden="true"></i>
