<?php

namespace App\Http\Requests\Equipment;

use App\Rules\EquipmentType;
use App\Rules\SerialNumberMaska;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rule;


class StoreEquipment extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $typeIds = $this->input('*.equipment_type_id');

        return [
            '*.equipment_type_id' => 'required|numeric|min:0|not_in:0',
            '*.serial_number' => [
                'required',
                new EquipmentType($typeIds),
                new SerialNumberMaska($typeIds)
            ],
            '*.desc' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.serial_number.required' => 'A serial_number is required',
            '*.serial_number.string' => 'A serial_number is string',
            '*.desc.required' => 'A desc is required',
            '*.desc.string' => 'A desc is string',
        ];
    }

    /**
     * Check for validator success flag.
     *
     * @return bool
     */
    public function validatorPasses(): bool
    {
        return !$this->validatorFails();
    }

    /**
     * Check for validator fail flag.
     *
     * @return bool
     */
    public function validatorFails(): bool
    {
        return $this->getValidatorInstance()->fails();
    }

    /**
     * @return MessageBag
     */
    public function validatorErrors(): MessageBag
    {
        return $this->getValidatorInstance()->errors();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        //
    }
}
