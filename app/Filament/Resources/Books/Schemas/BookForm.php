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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'xl' => 3])
                    ->columnSpanFull()
                    ->schema([
                        // Main column
                        Group::make()
                            ->columnSpan(['xl' => 2])
                            ->schema([
                                Section::make('Basics')
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
                                    ]),

                                // Tabs instead of one long scroll
                                Tabs::make('Content')
                                    ->persistTabInQueryString()
                                    ->tabs([
                                        Tab::make('Description')
                                            ->icon('heroicon-o-document-text')
                                            ->schema([
                                                Textarea::make('short_description')
                                                    ->rows(3)
                                                    ->default(null),
                                                RichEditor::make('description')
                                                    ->default(null),
                                            ]),

                                        Tab::make('Images')
                                            ->icon('heroicon-o-photo')
                                            ->schema([
                                                Repeater::make('images')
                                                    ->relationship('images')
                                                    ->orderColumn('sort')
                                                    ->reorderable()
                                                    ->addActionLabel('Add image')
                                                    ->helperText('The first image is the cover. Drag to reorder. Images swap automatically in the shop.')
                                                    ->grid(['default' => 2, 'md' => 3, 'xl' => 4])
                                                    ->defaultItems(0)
                                                    ->schema([
                                                        FileUpload::make('path')
                                                            ->hiddenLabel()
                                                            ->image()
                                                            ->disk('public')
                                                            ->directory('books')
                                                            ->imagePreviewHeight('140')
                                                            ->maxSize(4096)
                                                            ->required(),
                                                    ]),
                                            ]),

                                        Tab::make('Demo PDF')
                                            ->icon('heroicon-o-document-arrow-up')
                                            ->schema([
                                                FileUpload::make('demo_pdf_path')
                                                    ->label('Sample / demo of the book (PDF)')
                                                    ->helperText('Shown on the book page as a free sample readers can open. PDF only, up to 20 MB.')
                                                    ->acceptedFileTypes(['application/pdf'])
                                                    ->disk('public')
                                                    ->directory('book-demos')
                                                    ->maxSize(20480)
                                                    ->downloadable()
                                                    ->openable()
                                                    ->default(null),
                                            ]),
                                    ]),
                            ]),

                        // Sidebar
                        Group::make()
                            ->columnSpan(['xl' => 1])
                            ->schema([
                                Section::make('Status')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Visible in the shop')
                                            ->default(true),
                                    ]),

                                Section::make('Price and stock')
                                    ->columns(2)
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
                                            ->helperText('Empty = not tracked.'),
                                    ]),

                                Section::make('Book details')
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('isbn')->label('ISBN')->default(null),
                                        TextInput::make('sku')->label('SKU')->default(null),
                                        TextInput::make('publisher')->default(null),
                                        TextInput::make('language')->default(null),
                                        TextInput::make('format')->default(null),
                                        TextInput::make('pages')->numeric()->default(null),
                                        DatePicker::make('published_at')->columnSpanFull(),
                                    ]),

                                Section::make('Shipping size')
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        TextInput::make('weight_grams')->numeric()->suffix('g')->default(null),
                                        TextInput::make('length_mm')->numeric()->suffix('mm')->default(null),
                                        TextInput::make('width_mm')->numeric()->suffix('mm')->default(null),
                                        TextInput::make('height_mm')->numeric()->suffix('mm')->default(null),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
