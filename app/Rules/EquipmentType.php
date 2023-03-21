<?php

namespace App\Rules;

use App\Models\Equipment;
use Illuminate\Contracts\Validation\Rule;

class EquipmentType implements Rule
{
    private array $typeIds;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($typeIds)
    {
        $this->typeIds = $typeIds;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $ind = strstr($attribute, '.', true);
        $typeId = $this->typeIds[$ind];

        return !Equipment::where('serial_number', 'LIKE', $value)
            ->where('equipment_type_id', $typeId)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This entry already exists.';
    }
}
