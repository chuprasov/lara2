<?php

namespace Support\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{
    abstract protected function thumbnailDir():string;

    public function makeThumbnail (string $size, string $method = 'resize'): string
    {
        $route = route('thumbnail', [
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'size' => $size,
            'file' => File::basename($this->{$this->thumbnailColumn()})
        ]);

        return $route;
    }

    public static function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}
