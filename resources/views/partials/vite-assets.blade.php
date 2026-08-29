@if (file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@elseif (file_exists(public_path('css/app.built.css')))
    <link rel="stylesheet" href="{{ public_asset('css/app.built.css') }}?v={{ filemtime(public_path('css/app.built.css')) }}">
    @if (file_exists(public_path('js/app.built.js')))
        <script type="module" src="{{ public_asset('js/app.built.js') }}?v={{ filemtime(public_path('js/app.built.js')) }}"></script>
    @endif
@else
    @php
        $vite = \App\Support\PublicAsset::viteEntries();
    @endphp
    @foreach ($vite['css'] as $href)
        <link rel="stylesheet" href="{{ $href }}">
    @endforeach
    @foreach ($vite['js'] as $src)
        <script type="module" src="{{ $src }}"></script>
    @endforeach
@endif
