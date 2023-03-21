<?php

namespace App\Http\Requests\EquipmentType;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\MessageBag;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:200',
            'mask' => 'regex:/^[NAaXZ]+$/|size:10'
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
}
