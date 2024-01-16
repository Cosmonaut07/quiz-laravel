<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OneTrueAnswer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $trueCount = collect($value)->where('is_correct', true)->count();
        return $trueCount == 1 ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One answer must be true.';
    }
}
