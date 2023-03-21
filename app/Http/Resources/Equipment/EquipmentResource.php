<?php

namespace App\Http\Resources\Equipment;

use App\Http\Resources\EquipmentType\ShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "equipment_type" => new ShortResource($this->typeEquipment),
            "serial_number" => $this->serial_number,
            "desc" => $this->desc,
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
