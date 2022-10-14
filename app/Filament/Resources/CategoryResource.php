<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-s-flag';

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
                    ->unique()
                    ->placeholder('Enter a name...')
                    ->rules('required', 'max:255'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->placeholder('Enter a slug...')
                    ->rules('required', 'max:255'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->disabled()
                    ->placeholder('Enter a code...')
                    ->rules('required', 'max:255')
                    ->helperText('This is a unique code for this category, it is generated automatically.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                                        ->dateTime('d-m-Y H:i:s')
                                        ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                                        ->dateTime('d-m-Y H:i:s')
                                        ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
