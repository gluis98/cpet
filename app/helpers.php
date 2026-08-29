<?php

use App\Support\PublicAsset;

if (! function_exists('public_asset')) {
    function public_asset(string $path): string
    {
        return PublicAsset::url($path);
    }
}
