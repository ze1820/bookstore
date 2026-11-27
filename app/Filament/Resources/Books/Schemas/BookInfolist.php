<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookInfolist
{
    public static function configure(Schema $schema): Schema
    {
        $money = fn ($state) => $state === null ? null : '$' . number_format($state / 100, 2);

        return $schema
            ->components([
                Grid::make(['default' => 1, 'xl' => 3])
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columnSpan(['xl' => 2])
                            ->schema([
                                Section::make('Book')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('title'),
                                        TextEntry::make('slug'),
                                        TextEntry::make('authors.name')->badge()->placeholder('-'),
                                        TextEntry::make('categories.name')->badge()->placeholder('-'),
                                        TextEntry::make('short_description')->placeholder('-')->columnSpanFull(),
                                        TextEntry::make('description')->html()->placeholder('-')->columnSpanFull(),
                                    ]),

                                Section::make('Images')
                                    ->collapsible()
                                    ->schema([
                                        ImageEntry::make('images.path')
                                            ->hiddenLabel()
                                            ->disk('public')
                                            ->imageHeight(140),
                                    ]),
                            ]),

                        Group::make()
                            ->columnSpan(['xl' => 1])
                            ->schema([
                                Section::make('Status and price')
                                    ->columns(2)
                                    ->schema([
                                        IconEntry::make('is_active')->label('Visible')->boolean(),
                                        TextEntry::make('stock')->numeric()->placeholder('-'),
                                        TextEntry::make('price_cents')->label('Price')->formatStateUsing($money),
                                        TextEntry::make('sale_price_cents')->label('Sale price')->formatStateUsing($money)->placeholder('-'),
                                        TextEntry::make('currency'),
                                        TextEntry::make('demo_pdf_path')
                                            ->label('Demo PDF')
                                            ->formatStateUsing(fn ($state) => $state ? basename($state) : null)
                                            ->url(fn ($record) => $record->demo_pdf_url, shouldOpenInNewTab: true)
                                            ->placeholder('None'),
                                    ]),

                                Section::make('Details')
                                    ->columns(2)
                                    ->collapsible()
                                    ->schema([
                                        TextEntry::make('isbn')->label('ISBN')->placeholder('-'),
                                        TextEntry::make('sku')->label('SKU')->placeholder('-'),
                                        TextEntry::make('publisher')->placeholder('-'),
                                        TextEntry::make('language')->placeholder('-'),
                                        TextEntry::make('format')->placeholder('-'),
                                        TextEntry::make('pages')->numeric()->placeholder('-'),
                                        TextEntry::make('published_at')->date()->placeholder('-'),
                                        TextEntry::make('weight_grams')->numeric()->suffix(' g')->placeholder('-'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
