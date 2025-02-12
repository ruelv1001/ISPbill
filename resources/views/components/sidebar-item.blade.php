@php
    $classes = ($active ?? false)
        ? 'width: 100%; display: flex; align-items: center; padding: 12px 24px; cursor: pointer; background-color: #eef2ff; color: #312e81; outline: none; border-right: 4px solid #312e81; font-size: 14px; transition: all 0.3s ease;'
        : 'width: 100%; display: flex; align-items: center; padding: 12px 24px; color: #4b5563; cursor: pointer; transition: all 0.3s ease; font-size: 14px;';
@endphp

<a {{ $attributes->merge(['style' => $classes]) }}>
    <span style="display: flex; align-items: center;">
        {{ $slot }}
    </span>
</a>