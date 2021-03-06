<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUser implements Rule
{
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param string $message
     */
    public function __construct(string $message = 'The selected :attribute is invalid.')
    {
        $this->message = $message;
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
        return config('vodeamanager.models.user')::where('id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __($this->message);
    }
}
