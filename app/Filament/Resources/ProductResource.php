<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Domain\Catalog\Models\Brand;
use Filament\Resources\Resource;
use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Domain\Catalog\Models\Category;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                /* Select::make('brand_id')
                    ->options(Brand::all()->pluck('title', 'id')), */
                Select::make('brand_id')
                    ->relationship('brand', 'title'),
                FileUpload::make('thumbnail')
                    ->disk('images')
                    ->directory('products'),
                Checkbox::make('on_home_page'),
                TextInput::make('price')
                    ->numeric(),
                RichEditor::make('text'),
                CheckboxList::make('categories')
                    ->relationship('categories', 'title'),
                CheckboxList::make('optionValues')
                    ->relationship('optionValues', 'title'),
                CheckboxList::make('properties')
                    ->relationship('properties', 'title'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                /* ImageColumn::make('thumbnail')
                    ->disk('images'), */
                CheckboxColumn::make('on_home_page'),
                TextColumn::make('brand.title')
                    ->badge(),
                TextColumn::make('price')
                    ->money('RUR', divideBy: 100),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
