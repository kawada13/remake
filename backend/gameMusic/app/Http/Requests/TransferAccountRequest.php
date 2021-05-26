<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferAccountRequest extends FormRequest
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
            'bank_name' => 'required',
            'bank_code' => 'required|integer',
            'branch_name' => 'required',
            'branch_number' => 'required|integer',
            'deposit_type' => 'required',
            'account_number' => 'required|integer',
            'account_holder' => 'required',
        ];
    }
}
