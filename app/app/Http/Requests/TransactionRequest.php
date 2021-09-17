<?php

namespace App\Http\Requests;

use App\Rules\IsCommonUser;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TransactionRequest extends FormRequest
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
            'payer_id'  => ['required', 'integer', Rule::exists('users', 'id'), new IsCommonUser],
            'payee_id'  => ['required', 'integer', Rule::exists('users', 'id')],
            'value'     => ['required']
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

        throw new HttpResponseException(response()->json($validator->errors(), 422));
        // throw new ValidationException($validator, response()->json($data, 422));
    }
}
