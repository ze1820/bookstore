<?php

namespace App\Filament\Resources\FormSubmissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FormSubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')->badge(),
                TextEntry::make('created_at')->label('Received')->dateTime(),
                TextEntry::make('name'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('phone')->placeholder('Not provided'),
                TextEntry::make('message')->columnSpanFull(),
            ]);
    }
}