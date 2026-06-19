@php
    $backFallback = $fallback ?? route('siswa.dashboard');
@endphp

<button
    type="button"
    data-back-button
    data-fallback-url="{{ $backFallback }}"
    class="inline-flex items-center gap-2 rounded-md bg-white px-3.5 py-2 text-sm font-bold text-blue-700 shadow-sm hover:bg-blue-50 transition"
>
    <img src="{{ asset('asset/back.svg') }}" alt="" class="h-4 w-4 object-contain">
    <span>Kembali</span>
</button>
