<?php

namespace App\Http\Requests;

use App\Rules\HasBalance;
use App\Rules\IsCommonUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'value'     => ['required', 'numeric', new HasBalance($this->input('payer_id'))]
        ];
    }
}
