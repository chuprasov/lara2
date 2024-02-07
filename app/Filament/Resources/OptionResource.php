<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionResource\Pages;
use Domain\Product\Models\Option;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OptionResource extends Resource
{
    protected static ?string $model = Option::class;

    protected static ?string $navigationLabel = 'Опции';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 500;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
            ])->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOptions::route('/'),
            'create' => Pages\CreateOption::route('/create'),
            'edit' => Pages\EditOption::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
