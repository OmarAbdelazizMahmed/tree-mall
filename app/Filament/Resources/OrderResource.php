<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('confirmation_number')
                    ->required()
                    ->autofocus()
                    ->unique()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_email')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_name')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_city')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_address')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_postalcode')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_phone')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_discount')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_discount_code')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_subtotal')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_tax')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('billing_total')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\TextInput::make('payment_gateway')
                    ->required()
                    ->rules('required', 'max:255')
                    ->disabled(),
                Forms\Components\Toggle::make('shipped')
                    ->required()
                    ->rules('required', 'max:255'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'declined' => 'Declined',
                    ])
                    ->required()
                    ->rules('required', 'max:255'),
                // display the order products
                Forms\Components\HasManyRepeater::make('products')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->rules('required', 'max:255')
                            ->disabled(),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->rules('required', 'max:255')
                            ->disabled(),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->rules('required', 'max:255')
                            ->disabled(),
                    ])
                    ->disabled(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('confirmation_number')
                    ->label('Confirmation Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('billing_total')
                    ->label('Total')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([


            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    protected static function view()
    {

    }
    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
