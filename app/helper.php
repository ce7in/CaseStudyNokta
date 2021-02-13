<?php
/*
 * Asset functions
*/
function image(string $path = ''): string
{
    return rootAsset(config('app.imagesDir') . $path);
}

function rootAsset($path): string
{
    return env('APP_URL') . '/' . $path;
}