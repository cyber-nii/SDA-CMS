@props(['variant' => 'primary', 'size' => 'md', 'href' => null])

@php
$base = 'inline-flex items-center font-semibold border rounded-lg transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed';

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2 text-sm',
    'lg' => 'px-5 py-2.5 text-base',
];

$variants = [
    'primary'   => 'bg-primary-600 text-white border-transparent hover:bg-primary-700 active:bg-primary-900 focus:ring-primary-500',
    'secondary' => 'bg-white text-neutral-700 border-neutral-300 hover:bg-neutral-50 active:bg-neutral-100 focus:ring-primary-500',
    'danger'    => 'bg-red-600 text-white border-transparent hover:bg-red-500 active:bg-red-700 focus:ring-red-500',
    'success'   => 'bg-emerald-600 text-white border-transparent hover:bg-emerald-500 active:bg-emerald-700 focus:ring-emerald-500',
    'ghost'     => 'bg-transparent text-neutral-700 border-transparent hover:bg-neutral-100 active:bg-neutral-200 focus:ring-primary-500 shadow-none',
];

$classes = $base . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>{{ $slot }}</button>
@endif
