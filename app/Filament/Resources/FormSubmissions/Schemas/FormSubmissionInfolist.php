<?php

namespace App\Filament\Resources\FormSubmissions\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextEntry::make('created_at')->label('Received')->dateTime(),
                TextEntry::make('name'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('phone')->placeholder('Not provided'),
                TextEntry::make('message')
                    ->label('Message')
                    ->columnSpanFull(),

                RepeatableEntry::make('answers')
                    ->label('Other answers')
                    ->columnSpanFull()
                    ->visible(fn ($record) => filled($record->data))
                    ->state(fn ($record) => collect($record->data ?? [])
                        ->map(fn ($value, $key) => [
                            'label' => Str::headline($key),
                            'value' => match (true) {
                                is_array($value) => implode(', ', $value),
                                is_bool($value) => $value ? 'Yes' : 'No',
                                blank($value) => 'Not provided',
                                default => (string) $value,
                            },
                        ])
                        ->values()
                        ->all())
                    ->schema([
                        TextEntry::make('label')->hiddenLabel()->weight('bold'),
                        TextEntry::make('value')->hiddenLabel(),
                    ]),
            ]);
    }
}