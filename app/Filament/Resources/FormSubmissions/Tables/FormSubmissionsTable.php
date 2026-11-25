<?php

namespace App\Filament\Resources\FormSubmissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FormSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn ($record) => $record->read_at ? FontWeight::Normal : FontWeight::Bold),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('message')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'contact' => 'Contact',
                        'volunteer' => 'Volunteer',
                        'mentorship' => 'Mentorship',
                    ]),
                TernaryFilter::make('read_at')
                    ->label('Read')
                    ->nullable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}