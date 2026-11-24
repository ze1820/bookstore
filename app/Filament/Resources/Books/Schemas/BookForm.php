<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basics')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, string $operation) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state ?? ''));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the web address. Changing it later breaks old links.'),
                        Select::make('authors')
                            ->relationship('authors', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                                TextInput::make('slug')->required(),
                            ]),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                                TextInput::make('slug')->required(),
                            ]),
                        Toggle::make('is_active')
                            ->label('Visible in the shop')
                            ->default(true),
                    ]),

                Section::make('Description')
                    ->columnSpanFull()
                    ->schema([
                        Textarea::make('short_description')
                            ->rows(3)
                            ->default(null),
                        RichEditor::make('description')
                            ->default(null),
                    ]),

                Section::make('Images')
                    ->columnSpanFull()
                    ->description('The first image is the cover. Drag to reorder.')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->orderColumn('sort')
                            ->reorderable()
                            ->addActionLabel('Add image')
                            ->schema([
                                FileUpload::make('path')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('books')
                                    ->maxSize(4096)
                                    ->required(),
                            ]),
                    ]),

                Section::make('Price and stock')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
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
                            ->default('CAD')
                            ->maxLength(3),
                        TextInput::make('stock')
                            ->numeric()
                            ->default(null)
                            ->helperText('Leave empty if stock is not tracked.'),
                    ]),

                Section::make('Book details')
                    ->columnSpanFull()
                    ->columns(3)
                    ->collapsed()
                    ->schema([
                        TextInput::make('isbn')->label('ISBN')->default(null),
                        TextInput::make('sku')->label('SKU')->default(null),
                        TextInput::make('publisher')->default(null),
                        TextInput::make('language')->default(null),
                        TextInput::make('format')->default(null),
                        TextInput::make('pages')->numeric()->default(null),
                        DatePicker::make('published_at'),
                    ]),

                Section::make('Shipping size')
                    ->columnSpanFull()
                    ->columns(4)
                    ->collapsed()
                    ->schema([
                        TextInput::make('weight_grams')->numeric()->suffix('g')->default(null),
                        TextInput::make('length_mm')->numeric()->suffix('mm')->default(null),
                        TextInput::make('width_mm')->numeric()->suffix('mm')->default(null),
                        TextInput::make('height_mm')->numeric()->suffix('mm')->default(null),
                    ]),
            ]);
    }
}