<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PricingPlanResource\Pages;
use App\Models\PricingPlan;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PricingPlanResource extends Resource
{
    protected static ?string $model = PricingPlan::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-currency-dollar';
    }

    public static function getNavigationSort(): int
    {
        return 5;
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
                        FormComponents\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        FormComponents\TextInput::make('period')
                            ->default('Monthly')
                            ->maxLength(50),
                        FormComponents\Toggle::make('is_popular')
                            ->default(false),
                        FormComponents\TextInput::make('badge')
                            ->helperText('e.g. POPULAR')
                            ->maxLength(50),
                        FormComponents\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        FormComponents\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

                Components\Section::make('Features')
                    ->schema([
                        FormComponents\Repeater::make('features')
                            ->schema([
                                FormComponents\TextInput::make('feature')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->defaultItems(3)
                            ->addActionLabel('Add Feature')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('period'),
                Tables\Columns\IconColumn::make('is_popular')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPricingPlans::route('/'),
            'create' => Pages\CreatePricingPlan::route('/create'),
            'edit' => Pages\EditPricingPlan::route('/{record}/edit'),
        ];
    }
}
