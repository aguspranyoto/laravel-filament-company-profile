<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chat-bubble-left-ellipsis';
    }

    public static function getNavigationSort(): int
    {
        return 6;
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
                        FormComponents\TextInput::make('role')
                            ->helperText('e.g. CEO, Tech Corp')
                            ->maxLength(255),
                        FormComponents\TextInput::make('company')
                            ->maxLength(255),
                        FormComponents\Select::make('rating')
                            ->options([
                                5 => '★★★★★',
                                4 => '★★★★☆',
                                3 => '★★★☆☆',
                                2 => '★★☆☆☆',
                                1 => '★☆☆☆☆',
                            ])
                            ->default(5)
                            ->required(),
                        FormComponents\Textarea::make('quote')
                            ->required()
                            ->rows(3),
                        FormComponents\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        FormComponents\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Components\Section::make('Avatar')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->label('Client Avatar')
                            ->collection('avatar')
                            ->disk('public')
                            ->directory('testimonials')
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
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
