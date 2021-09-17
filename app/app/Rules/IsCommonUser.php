<?php

namespace App\Rules;

use App\Repositories\Contracts\UsersRepositoryContract;
use App\Repositories\UsersRepository;
use Illuminate\Contracts\Validation\Rule;

class IsCommonUser implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $repository = new UsersRepository();
        return $repository->isCommon($value);
        // return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This user can only receive transfers.';
    }
}
