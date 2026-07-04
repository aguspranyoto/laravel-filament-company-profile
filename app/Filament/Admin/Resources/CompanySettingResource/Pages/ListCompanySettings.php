<?php

namespace App\Filament\Admin\Resources\CompanySettingResource\Pages;

use App\Filament\Admin\Resources\CompanySettingResource;
use App\Models\CompanySetting;
use Filament\Resources\Pages\ListRecords;

class ListCompanySettings extends ListRecords
{
    protected static string $resource = CompanySettingResource::class;

    public function mount(): void
    {
        parent::mount();

        $setting = CompanySetting::instance();
        $this->redirect(route('filament.admin.resources.company-settings.edit', ['record' => $setting]));
    }
}
