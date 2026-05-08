@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm transition-colors py-2.5 text-sm text-neutral-900 placeholder-neutral-400']) }}>
