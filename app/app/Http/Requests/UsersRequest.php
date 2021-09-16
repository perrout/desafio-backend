<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersRequest extends FormRequest
{
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

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => false,
            'error' => $validator->errors()
        ];
        throw new ValidationException($validator, response()->json($data, 422));
    }
}
