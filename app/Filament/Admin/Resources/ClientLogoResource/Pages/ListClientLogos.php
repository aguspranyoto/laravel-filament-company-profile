<?php

namespace App\Filament\Admin\Resources\ClientLogoResource\Pages;

use App\Filament\Admin\Resources\ClientLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientLogos extends ListRecords
{
    protected static string $resource = ClientLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
