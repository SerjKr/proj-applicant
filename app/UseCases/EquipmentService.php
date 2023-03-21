<?php

namespace App\UseCases;

use App\Http\Resources\Equipment\EquipmentResource;
use App\Http\Resources\EquipmentErrorResource;
use App\Http\Resources\ResponseResource;
use App\Models\Equipment;
use App\Models\EquipmentType;

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

        $unique = $this->findDouble($success);
        $various = $this->preErrors($success, $unique);
        $this->addErrors($various, $errors);
        $sectionErrors = new EquipmentErrorResource($errors);

        foreach ($unique as $item) {
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

        return new ResponseResource(
            collect(['errors' => $sectionErrors, 'success' => $sectionSuccess])
        );
    }

    /**
     * @param $success
     * @return mixed
     */
    private function findDouble($success): mixed
    {
        return $success->unique(function ($item) {
            return $item['equipment_type_id'] . $item['serial_number'];
        });
    }

    /**
     * @param $success
     * @param mixed $unique
     * @return mixed
     */
    private function preErrors($success, mixed $unique): mixed
    {
        return $success->diffKeys($unique)->mapWithKeys(function ($item, $key) {
            return [$key => ['Double Serial number']];
        });
    }

    /**
     * @param mixed $various
     * @param $errors
     * @return void
     */
    private function addErrors(mixed $various, $errors): void
    {
        $various->map(fn($item, $key) => $errors->put($key, $item));
    }
}
