<?php

namespace App\Http\Requests;

use App\Models\Medcine;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMedcineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "sciName"=>['required'],
            "useName"=>['required','unique:medcines'],
            "companyName"=>['required'],
            "qtn"=>['required'],
            "expiredDate"=>['required'],
            "price"=> ['required'],
           "description"=> ['required'],
           "category_id"=>['required','exists:categories,id']
        ];
    }
     // validation error handeling
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'message' => 'The given data is invalid.',
        ], 422));
    }
}
