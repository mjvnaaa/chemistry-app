{{-- resources/views/components/statistic-card.blade.php --}}

@props(['title', 'value', 'icon', 'color', 'extra' => null])

@php
    $ringColor = 'ring-'.$color.'-500';
    $borderColor = 'border-'.$color.'-500';
    $iconColor = 'text-'.$color.'-500';
@endphp

<div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ $borderColor }} transition duration-300 hover:shadow-xl hover:ring-2 {{ $ringColor }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-bold uppercase">{{ $title }}</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ $value }}
                @if($extra)
                    <span class="text-lg text-gray-500 ml-1 font-medium">{{ $extra }}</span>
                @endif
            </p>
        </div>
        <div class="text-5xl {{ $iconColor }} opacity-80">{{ $icon }}</div>
    </div>
</div>