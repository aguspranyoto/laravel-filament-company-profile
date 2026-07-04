<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClientLogoResource\Pages;
use App\Models\ClientLogo;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ClientLogoResource extends Resource
{
    protected static ?string $model = ClientLogo::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-user-group';
    }

    public static function getNavigationLabel(): string
    {
        return 'Client Logos';
    }

    public static function getNavigationSort(): int
    {
        return 8;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make()
                    ->schema([
                        FormComponents\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        FormComponents\TextInput::make('url')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Optional link when logo is clicked'),
                        FormComponents\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        FormComponents\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Components\Section::make('Logo Image')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Client Logo')
                            ->collection('logo')
                            ->disk('public')
                            ->directory('clients')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientLogos::route('/'),
            'create' => Pages\CreateClientLogo::route('/create'),
            'edit' => Pages\EditClientLogo::route('/{record}/edit'),
        ];
    }
}
