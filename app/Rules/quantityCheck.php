<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Medcine;

class QuantityCheck implements Rule
{
    private $medcineId;

    public function __construct($medcineId)
    {
        $this->medcineId = $medcineId;
    }

    public function passes($attribute, $value)
    {
        $medcine = Medcine::find($this->medcineId);
        return $medcine && $medcine[0]->qtn >= $value;
    }

    public function message()
    {
        return 'The selected :attribute is invalid.';
    }
}