<!-- resources/views/components/image.blade.php -->

@if($isSvg)
    {{-- If the image source is an SVG, output it directly --}}
    <div class="{{ $class }}"
    style="
        @if($width && $height)
            height: {{ $width }}px;
            width: {{ $height }}px;
        @elseif($width)
            width: {{ $width }}px;
        @endif
        ">
        {!! file_get_contents(public_path($src)) !!}
    </div>
@else
    {{-- For other image types, use the standard <img> tag --}}
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        class="{{ $class }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
    />
@endif
