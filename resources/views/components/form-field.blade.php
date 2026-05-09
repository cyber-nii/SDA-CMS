@props(['label' => null, 'for' => null, 'error' => null, 'hint' => null])

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if($label)
        <x-input-label :for="$for" :value="$label" />
    @endif
    {{ $slot }}
    @if($error)
        <x-input-error :messages="$error" />
    @endif
    @if($hint && !$error)
        <p class="text-xs text-neutral-500">{{ $hint }}</p>
    @endif
</div>
