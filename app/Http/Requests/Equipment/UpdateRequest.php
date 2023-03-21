<?php

namespace App\Http\Requests\Equipment;

use App\Rules\EquipmentType;
use App\Rules\SerialNumberMaska;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = request()->route('equipment')->id;

        return [
            'serial_number' => [
                'required',
                new SerialNumberMaska(null, $id)
            ],
            'desc' => 'required|string',
        ];
    }
}
