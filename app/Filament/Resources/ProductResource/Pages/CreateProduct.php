<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\AvailabilityStatus;
use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['availability_status'] ?? null) !== AvailabilityStatus::PreOrder->value) {
            $data['estimated_production_days'] = null;
        }

        return $data;
    }
}
