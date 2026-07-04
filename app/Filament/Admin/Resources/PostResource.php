<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-newspaper';
    }

    public static function getNavigationLabel(): string
    {
        return 'Blog / News';
    }

    public static function getNavigationSort(): int
    {
        return 7;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Post Info')
                    ->schema([
                        FormComponents\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) =>
                                $set('slug', \Illuminate\Support\Str::slug($state ?? ''))
                            ),
                        FormComponents\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        FormComponents\DatePicker::make('published_at')
                            ->label('Publish Date'),
                        FormComponents\Toggle::make('is_published')
                            ->default(false),
                    ])->columns(2),

                Components\Section::make('Content')
                    ->schema([
                        FormComponents\Textarea::make('excerpt')
                            ->rows(2)
                            ->helperText('Short summary shown on blog listing')
                            ->columnSpanFull(),
                        FormComponents\RichEditor::make('content')
                            ->label('Full Content')
                            ->columnSpanFull()
                            ->helperText('Full article content with rich text formatting'),
                    ]),

                Components\Section::make('Featured Image')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('featured-image')
                            ->label('Featured Image')
                            ->collection('featured-image')
                            ->disk('public')
                            ->directory('posts')
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
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
