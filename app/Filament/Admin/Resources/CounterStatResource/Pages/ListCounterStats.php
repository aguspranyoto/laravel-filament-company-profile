<?php

namespace App\Filament\Admin\Resources\CounterStatResource\Pages;

use App\Filament\Admin\Resources\CounterStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCounterStats extends ListRecords
{
    protected static string $resource = CounterStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
