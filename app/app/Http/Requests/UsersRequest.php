<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UsersRequest extends FormRequest
{
    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'document' => ['required', $this->id ? Rule::unique('users', 'document')->ignore($this->id) : ''],
            'wallet' => ['required','numeric','min:0.01'],
            'email' => ['required', $this->id ? Rule::unique('users', 'email')->ignore($this->id) : ''],
            'status' => ['sometimes','required'],
            'type' => ['sometimes','required']
        ];
    }
}
