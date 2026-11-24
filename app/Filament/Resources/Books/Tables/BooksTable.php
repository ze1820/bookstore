<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('wp_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('isbn')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('price_cents')
                    ->label('Price')
                    ->formatStateUsing(fn ($state) => $state === null ? '' : '$' . number_format($state / 100, 2))
                    ->sortable(),
                TextColumn::make('sale_price_cents')
                    ->label('Sale price')
                    ->formatStateUsing(fn ($state) => $state === null ? '' : '$' . number_format($state / 100, 2))
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('publisher')
                    ->searchable(),
                TextColumn::make('language')
                    ->searchable(),
                TextColumn::make('format')
                    ->searchable(),
                TextColumn::make('pages')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight_grams')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('length_mm')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('width_mm')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('height_mm')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
