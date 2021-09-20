<?php

namespace App\Rules;

use App\Repositories\Users\UsersRepository;
use Illuminate\Contracts\Validation\Rule;

class HasBalance implements Rule
{
    private $repository;
    private $userId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->repository = new UsersRepository();
        $this->userId = $userId;
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
        return $this->repository->hasBalance($this->userId, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Account with insufficient founds.';
    }
}
