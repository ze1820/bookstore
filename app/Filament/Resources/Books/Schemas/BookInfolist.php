<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('wp_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('isbn')
                    ->placeholder('-'),
                TextEntry::make('sku')
                    ->label('SKU')
                    ->placeholder('-'),
                TextEntry::make('short_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('price_cents')
                    ->numeric(),
                TextEntry::make('sale_price_cents')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('currency'),
                TextEntry::make('stock')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('publisher')
                    ->placeholder('-'),
                TextEntry::make('language')
                    ->placeholder('-'),
                TextEntry::make('format')
                    ->placeholder('-'),
                TextEntry::make('pages')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight_grams')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('length_mm')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('width_mm')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('height_mm')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('published_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
