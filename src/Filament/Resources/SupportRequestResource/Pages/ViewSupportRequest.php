<?php

namespace Sfolador\Support\Filament\Resources\SupportRequestResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Sfolador\Support\Filament\Resources\SupportRequestResource;

class ViewSupportRequest extends ViewRecord
{
    protected static string $resource = SupportRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
