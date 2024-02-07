<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Domain\Product\Models\Property;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title'),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        Select::make('recordId')
                            ->label('Property')
                            ->options(function () {
                                $existedProperties = $this->ownerRecord->properties->pluck('id')->toArray();

                                return Property::whereNotIn('id', $existedProperties)->pluck('title', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('value')
                            ->required(),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                Tables\Actions\EditAction::make()
                    ->form(fn (Tables\Actions\EditAction $action): array => [
                        Forms\Components\TextInput::make('value')
                            ->required(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
