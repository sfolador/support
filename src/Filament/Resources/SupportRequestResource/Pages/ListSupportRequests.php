<?php

namespace Sfolador\Support\Filament\Resources\SupportRequestResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Sfolador\Support\Filament\Resources\SupportRequestResource;

class ListSupportRequests extends ListRecords
{
    protected static string $resource = SupportRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
