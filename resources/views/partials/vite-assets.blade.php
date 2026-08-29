@php
    $vite = \App\Support\PublicAsset::viteEntries();
@endphp
@if ($vite['hot'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    @foreach ($vite['css'] as $href)
        <link rel="stylesheet" href="{{ $href }}">
    @endforeach
    @foreach ($vite['js'] as $src)
        <script type="module" src="{{ $src }}"></script>
    @endforeach
@endif
