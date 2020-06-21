<?php

namespace Vodeamanager\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ValidPassword implements Rule
{
    protected $id;
    protected $password;
    protected $message;

    /**
     * Create a new rule instance.
     *
     * @param $password
     * @param null $id
     * @param string $message
     */
    public function __construct($password, $id = null, string $message = 'Password is incorrect.')
    {
        $this->id = $id ?? Auth::id();
        $this->password = $password;
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
        $user = config('vodeamanager.models.user')::find($this->id);

        return Hash::check($this->password, $user->password);
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
