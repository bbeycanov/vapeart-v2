<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Contact Information'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name')),
                        TextEntry::make('email')
                            ->label(__('Email'))
                            ->copyable(),
                        TextEntry::make('created_at')
                            ->label(__('Created at'))
                            ->dateTime(),
                        IconEntry::make('is_read')
                            ->label(__('Read Status'))
                            ->boolean(),
                    ]),
                Section::make(__('Message'))
                    ->schema([
                        TextEntry::make('message')
                            ->label(__('Message'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
