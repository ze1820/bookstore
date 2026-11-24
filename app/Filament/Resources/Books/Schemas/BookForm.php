<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('wp_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('isbn')
                    ->default(null),
                TextInput::make('sku')
                    ->label('SKU')
                    ->default(null),
                Textarea::make('short_description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price_cents')
                    ->label('Price')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->formatStateUsing(fn ($state) => $state === null ? null : $state / 100)
                    ->dehydrateStateUsing(fn ($state) => (int) round($state * 100)),
                TextInput::make('sale_price_cents')
                    ->label('Sale price')
                    ->numeric()
                    ->prefix('$')
                    ->formatStateUsing(fn ($state) => $state === null ? null : $state / 100)
                    ->dehydrateStateUsing(fn ($state) => $state === null || $state === '' ? null : (int) round($state * 100))
                    ->default(null),
                TextInput::make('currency')
                    ->required()
                    ->default('CAD'),
                TextInput::make('stock')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('publisher')
                    ->default(null),
                TextInput::make('language')
                    ->default(null),
                TextInput::make('format')
                    ->default(null),
                TextInput::make('pages')
                    ->numeric()
                    ->default(null),
                TextInput::make('weight_grams')
                    ->numeric()
                    ->default(null),
                TextInput::make('length_mm')
                    ->numeric()
                    ->default(null),
                TextInput::make('width_mm')
                    ->numeric()
                    ->default(null),
                TextInput::make('height_mm')
                    ->numeric()
                    ->default(null),
                DatePicker::make('published_at'),
            ]);
    }
}
