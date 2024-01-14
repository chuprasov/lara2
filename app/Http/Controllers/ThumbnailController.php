<?php

namespace App\Http\Controllers;

use Nette\Utils\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __invoke(
        string $dir,
        string $method,
        string $size,
        string $file
    ): BinaryFileResponse
    {
        abort_if(
            !in_array($size, config('thumbnail.allowed_sizes')),
            403,
            'Size not allowed'
        );

        $disk = Storage::disk('images');

        $realPath = "$dir/$file";
        $newDirPath = "$dir/$method/$size";
        $resultPath = "$newDirPath/$file";

        if (!$disk->exists($newDirPath)) {
            $disk->makeDirectory($newDirPath);
        }

        if (!$disk->exists($resultPath)) {

            $image = Image::fromFile($disk->path($realPath));

            [$w, $h] = explode('x', $size);

            $image->{$method}($w, $h);

            $image->save($disk->path($resultPath));
        }

        return response()->file($disk->path($resultPath));
    }

}
