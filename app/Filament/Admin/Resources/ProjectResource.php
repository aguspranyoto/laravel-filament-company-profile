<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-briefcase';
    }

    public static function getNavigationSort(): int
    {
        return 4;
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
                        FormComponents\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        FormComponents\TextInput::make('category')
                            ->helperText('e.g. Business, Finance, Digital')
                            ->maxLength(255),
                        FormComponents\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        FormComponents\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Components\Section::make('Project Image')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('project-image')
                            ->label('Project Image')
                            ->collection('project-image')
                            ->disk('public')
                            ->directory('projects')
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
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
