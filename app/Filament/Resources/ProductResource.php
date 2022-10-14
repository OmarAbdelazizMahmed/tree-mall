<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\RelationManagers\CategoriesRelationManager;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Livewire\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                        $nameParts = explode(' ', trim($state));
                        $firstPart = array_shift($nameParts);
                        $secondPart = array_pop($nameParts);
                        $set('code', Str::upper(substr($firstPart, 0, 1) . substr($secondPart, 0, 1)));
                    })
                    ->required()
                    ->autofocus()
                    ->placeholder('Enter a name...')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->placeholder('Enter a slug...')
                    ->rules('required', 'max:255'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->disabled()
                    ->placeholder('Enter a code...'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->placeholder('Enter a price...')
                    ->rules('required', 'max:255'),
                // details
                Forms\Components\TextInput::make('details')
                    ->required()
                    ->placeholder('Enter a details...')
                    ->rules('required', 'max:255'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->cols(2)
                    ->required()
                    ->placeholder('Enter a description...')
                    ->rules('required', 'max:255'),
                // price
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->placeholder('Enter a price...')
                    ->rules('gte:500'),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->integer()
                    ->required()
                    ->placeholder('Enter a quantity...')
                    ->rules('gte:1'),
                CheckboxList::make('categories')
                    ->relationship('categories', 'name')
                    ->required(),
                Forms\Components\FileUpload::make('main_image')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $filename = $file->hashName();
                        $name = explode('.', $filename);
                        return (string) 'image/products/main_images/' . $name[0] . '.png';
                    })
                    ->required()
                    ->image()
                    ->label('Main Image')
                    ->placeholder('Upload an image...'),
                Forms\Components\FileUpload::make('alt_images')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $filename = $file->hashName();
                        $name = explode('.', $filename);
                        return (string) 'image/products/alt_images/' . $name[0] . '.png';
                    })
                    ->image()
                    ->required()
                    ->multiple()
                    ->label('Alternative Image')
                    ->placeholder('Upload an image...'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image'),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('price')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('quantity')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
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
