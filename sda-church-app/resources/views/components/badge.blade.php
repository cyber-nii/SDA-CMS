@props(['status' => null, 'variant' => null])

@php
$key = $variant ?? $status ?? 'default';

$map = [
    // Member statuses
    'Active'      => 'bg-green-100 text-green-800',
    'Inactive'    => 'bg-yellow-100 text-yellow-800',
    'Transferred' => 'bg-primary-100 text-primary-800',
    'Deceased'    => 'bg-red-100 text-red-800',
    // Roles
    'Super Admin'       => 'bg-primary-100 text-primary-700',
    'Pastor'            => 'bg-violet-100 text-violet-700',
    'Clerk'             => 'bg-violet-100 text-violet-700',
    'Head Elder'        => 'bg-violet-100 text-violet-700',
    'Department Leader' => 'bg-violet-100 text-violet-700',
    'Treasurer'         => 'bg-emerald-100 text-emerald-700',
    'Funds Controller'  => 'bg-secondary-100 text-secondary-700',
    'Member'            => 'bg-neutral-100 text-neutral-600',
    // Generic semantic variants
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
    'danger'  => 'bg-red-100 text-red-800',
    'info'    => 'bg-primary-100 text-primary-700',
    'default' => 'bg-neutral-100 text-neutral-700',
];

$colorClass = $map[$key] ?? $map['default'];
@endphp

<span {{ $attributes->merge(['class' => "px-2 inline-flex text-xs leading-5 font-semibold rounded-full $colorClass"]) }}>
    {{ $slot ?? $status }}
</span>
