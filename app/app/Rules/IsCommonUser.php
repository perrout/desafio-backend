<?php

namespace App\Rules;

use App\Repositories\Users\UsersRepository;
use Illuminate\Contracts\Validation\Rule;

class IsCommonUser implements Rule
{
    private $repository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->repository = new UsersRepository();
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
        return $this->repository->isCommon($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This account can only receive transfers.';
    }
}
