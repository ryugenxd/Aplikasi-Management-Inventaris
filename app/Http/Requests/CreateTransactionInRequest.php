<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateTransactionInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this -> user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id"=>["required","integer"],
            "supplier_id"=>["required","integer"],
            "date_received"=>["required","date"],
            "quantity"=>["required","integer"],
            "date_received"=>["required","date"],
            "invoice_number"=>["required","string"]
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response([
            "errors"=>$validator->getMessageBag()
        ],400));
    }
}
