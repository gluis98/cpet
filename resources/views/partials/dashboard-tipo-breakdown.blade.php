@if(!empty($counts))
    <ul class="relative mt-3 space-y-1 border-t border-white/15 pt-3 text-xs">
        @foreach($counts as $tipo => $cantidad)
            @if($cantidad > 0)
                <li class="flex items-center justify-between gap-3 text-white/75">
                    <span>{{ $tipo }}</span>
                    <span class="font-semibold tabular-nums text-white">{{ number_format($cantidad, 0, '', '.') }}</span>
                </li>
            @endif
        @endforeach
    </ul>
@endif
