{{-- resources/views/components/alert.blade.php --}}

@props(['type', 'message'])

@php
    $bgColor = 'bg-'.$type.'-100';
    $borderColor = 'border-'.$type.'-500';
    $textColor = 'text-'.$type.'-700';
    $emoji = match($type) {
        'success' => '✅',
        'error' => '❌',
        default => 'ℹ️',
    };
@endphp

<div class="{{ $bgColor }} border-l-4 {{ $borderColor }} {{ $textColor }} p-4 mb-6 rounded-lg" role="alert">
    <div class="flex items-center gap-2">
        <span class="text-xl">{{ $emoji }}</span>
        <p class="font-semibold">{{ $message }}</p>
    </div>
</div>