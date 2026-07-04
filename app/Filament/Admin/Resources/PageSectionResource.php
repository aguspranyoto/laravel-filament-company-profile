<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageSectionResource\Pages;
use App\Models\PageSection;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationLabel(): string
    {
        return 'Page Sections';
    }

    public static function getNavigationSort(): int
    {
        return 2;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Section Info')
                    ->schema([
                        FormComponents\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique identifier: hero, about, benefits, who-we-are, contact')
                            ->maxLength(255),
                        FormComponents\TextInput::make('subtitle')
                            ->helperText('Small label above title, e.g. "ABOUT US", "KEY BENEFITS"')
                            ->maxLength(255),
                        FormComponents\TextInput::make('title')
                            ->helperText('Main heading for this section')
                            ->maxLength(255),
                        FormComponents\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Components\Section::make('Content')
                    ->schema([
                        FormComponents\RichEditor::make('content')
                            ->label('Section Content')
                            ->columnSpanFull()
                            ->helperText('Rich text content for this section. Use for about paragraphs, benefit descriptions, etc.'),
                    ]),

                Components\Section::make('Extra Data (JSON)')
                    ->schema([
                        FormComponents\KeyValue::make('extra')
                            ->label('Additional Data')
                            ->helperText('Key-value pairs for section-specific data.')
                            ->reorderable(),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->defaultSort('slug');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSections::route('/'),
            'create' => Pages\CreatePageSection::route('/create'),
            'edit' => Pages\EditPageSection::route('/{record}/edit'),
        ];
    }
}
