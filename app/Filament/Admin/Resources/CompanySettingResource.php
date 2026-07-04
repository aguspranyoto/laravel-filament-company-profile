<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanySettingResource\Pages;
use App\Models\CompanySetting;
use Filament\Forms\Components as FormComponents;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanySettingResource extends Resource
{
    protected static ?string $model = CompanySetting::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationLabel(): string
    {
        return 'Company Settings';
    }

    public static function getNavigationSort(): int
    {
        return 1;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Website Content';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Components\Section::make('Company Information')
                    ->schema([
                        FormComponents\TextInput::make('company_name')
                            ->required()
                            ->maxLength(255),
                        FormComponents\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        FormComponents\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        FormComponents\TextInput::make('address')
                            ->maxLength(255),
                    ])->columns(2),

                Components\Section::make('Logo')
                    ->schema([
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('logo')
                            ->label('Company Logo')
                            ->collection('logo')
                            ->disk('public')
                            ->directory('company')
                            ->image()
                            ->imageEditor()
                            ->panelLayout('integrated')
                            ->visibleOn('edit'),
                    ]),

                Components\Section::make('Social Media')
                    ->schema([
                        FormComponents\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255),
                        FormComponents\TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255),
                        FormComponents\TextInput::make('twitter_url')
                            ->label('Twitter / X URL')
                            ->url()
                            ->maxLength(255),
                    ])->columns(3),

                Components\Section::make('Footer')
                    ->schema([
                        FormComponents\Textarea::make('footer_description')
                            ->rows(3)
                            ->maxLength(500),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanySettings::route('/'),
            'edit' => Pages\EditCompanySetting::route('/{record}/edit'),
        ];
    }
}
