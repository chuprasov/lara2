<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\PropertiesRelationManager;
use Domain\Product\Models\Product;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationLabel = 'Товары';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 100;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Main')
                            ->schema([
                                TextInput::make('title'),
                                Select::make('brand_id')
                                    ->relationship('brand', 'title'),
                                TextInput::make('price')
                                    ->numeric(),
                                Checkbox::make('on_home_page'),
                            ])->columns(2),

                        Tabs\Tab::make('Image')
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->disk('images')
                                    ->directory('products'),
                            ]),

                        Tabs\Tab::make('Categories, options')
                            ->schema([
                                CheckboxList::make('categories')
                                    ->relationship('categories', 'title'),
                                CheckboxList::make('optionValues')
                                    ->relationship('optionValues', 'title'),
                            ])->columns(2),

                        Tabs\Tab::make('Description')
                            ->schema([
                                RichEditor::make('text'),
                            ]),

                    ])->columnSpan('full'),
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
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PropertiesRelationManager::class,
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
