@if (file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@elseif (file_exists(public_path('build/manifest.json')))
    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true) ?: [];
        $cssEntry = 'resources/css/app.css';
        $jsEntry = 'resources/js/app.js';
    @endphp
    @if (! empty($manifest[$cssEntry]['file']))
        <link rel="stylesheet" href="{{ asset('build/'.$manifest[$cssEntry]['file']) }}">
    @endif
    @if (! empty($manifest[$cssEntry]['css']))
        @foreach ($manifest[$cssEntry]['css'] as $cssFile)
            <link rel="stylesheet" href="{{ asset('build/'.$cssFile) }}">
        @endforeach
    @endif
    @if (! empty($manifest[$jsEntry]['file']))
        <script type="module" src="{{ asset('build/'.$manifest[$jsEntry]['file']) }}"></script>
    @endif
@endif
