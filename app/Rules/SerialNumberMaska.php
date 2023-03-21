<?php

namespace App\Rules;

use App\Models\Equipment;
use Illuminate\Contracts\Validation\Rule;
use App\Models\EquipmentType;

class SerialNumberMaska implements Rule
{
    private array|null $typeIds;
    private int|null $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($typeIds, $id = null)
    {
        $this->typeIds = $typeIds;
        $this->id = $id;
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
        if ($this->typeIds) {
            $index = strstr($attribute, '.', true);
            $id = $this->typeIds[$index];
            $type = EquipmentType::find($id);
        } else {
            $type = Equipment::find($this->id)->typeEquipment;
        }

        if (is_null($type)) {
            return false;
        }

        if (strlen($value) !== strlen($type->mask)) {
            return false;
        }

        $regx = [
            "N" => "[0-9]",
            "A" => "[A-Z]",
            "a" => "[a-z]",
            "X" => "[A-Z0-9]",
            "Z" => "[-|_|@]"
        ];

        $maskChars = str_split($type->mask);

        $outputRegex = "/^";
        foreach ($maskChars as $char) {
            $outputRegex .= $regx[$char];
        }
        $outputRegex .= "$/";

        return preg_match($outputRegex, $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Serial number format error.';
    }
}
