<?php

namespace App\Filament\Resources\IntegramResource\Pages;

use App\Filament\Resources\IntegramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntegram extends EditRecord
{
    protected static string $resource = IntegramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
