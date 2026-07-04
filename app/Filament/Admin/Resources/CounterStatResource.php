<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CounterStatResource\Pages;
use App\Models\CounterStat;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CounterStatResource extends Resource
{
    protected static ?string $model = CounterStat::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public static function getNavigationLabel(): string
    {
        return 'Counter Stats';
    }

    public static function getNavigationSort(): int
    {
        return 9;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                FormComponents\TextInput::make('number_value')
                    ->required()
                    ->helperText('e.g. 15+, 200+, 98%')
                    ->maxLength(20),
                FormComponents\TextInput::make('label')
                    ->required()
                    ->helperText('e.g. Years Experience, Project Completed')
                    ->maxLength(255),
                FormComponents\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                FormComponents\Toggle::make('is_active')
                    ->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number_value')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCounterStats::route('/'),
            'create' => Pages\CreateCounterStat::route('/create'),
            'edit' => Pages\EditCounterStat::route('/{record}/edit'),
        ];
    }
}
