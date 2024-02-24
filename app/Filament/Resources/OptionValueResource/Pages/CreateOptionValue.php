<?php

namespace App\Filament\Resources\OptionValueResource\Pages;

use App\Filament\Resources\OptionValueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOptionValue extends CreateRecord
{
    protected static string $resource = OptionValueResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
