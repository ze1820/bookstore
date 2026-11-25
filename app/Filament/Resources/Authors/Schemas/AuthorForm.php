<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state ?? ''));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('role')
                    ->label('Role')
                    ->helperText('For example: Founder & Author')
                    ->default(null),
                FileUpload::make('photo_path')
                    ->label('Photo')
                    ->image()
                    ->disk('public')
                    ->directory('authors')
                    ->maxSize(4096)
                    ->columnSpanFull(),
                Textarea::make('bio')
                    ->rows(8)
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}