<?php

namespace App\UseCases;

use App\Http\Resources\Equipment\EquipmentResource;
use App\Http\Resources\EquipmentErrorResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\DB;

class EquipmentService
{
    public function getData($request): array
    {
        $dataRequest = $request->validationData();
        $errorMessages = $request->validatorErrors();

        $errors = collect($errorMessages)
            ->groupBy(fn(array $item, string $key) => strstr($key, '.', true))
            ->sortKeys()
            ->map(fn($item, int $key) => $item->map(fn($arr) => $arr[0]));

        $errorKeys = $errors->keys()->toArray();

        $validData = collect($dataRequest)->except($errorKeys);

        return [$validData, $errors];
    }

    public function doAnswer($success, $errors)
    {
        $itemSuccess = [];
        $sectionErrors = new \App\Http\Resources\EquipmentErrorResource($errors);

        foreach ($success as $item) {
            $type = EquipmentType::find($item['equipment_type_id']);

            $equipment = Equipment::make([
                "serial_number" => $item['serial_number'],
                "desc" => $item['desc']
            ]);

            $equipment->typeEquipment()->associate($type);
            $equipment->saveOrFail();

            $itemSuccess[] = $equipment;
        }

        $sectionSuccess = EquipmentResource::collection($itemSuccess);

        return new \App\Http\Resources\ResponseResource(
            collect(['errors' => $sectionErrors, 'success' => $sectionSuccess])
        );
    }
}
