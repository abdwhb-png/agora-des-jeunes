@php
    $styles = $style();
@endphp

<div class="flex justify-center mb-0">
    <!--begin:Action-->
    <a href="{{ $url }}" target="_blank"
        style="background-color:{{ $styles->bg }}; border-radius:6px;display:inline-block; padding:11px 19px; color: {{ $styles->color }}; font-size: 14px; font-weight:500;">
        {{ $text }}
    </a>
    <!--begin:Action-->
</div>
