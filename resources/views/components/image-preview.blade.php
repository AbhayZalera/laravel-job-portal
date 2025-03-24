@props(['height', 'width', 'source'])
<div>
    @if ($source)
        <img {{ $attributes->merge(['style' => "height: {$height}px; width: {$width}px; object-fit: cover;"]) }}
            src="{{ $source }}" alt="">
    @endif
</div>
