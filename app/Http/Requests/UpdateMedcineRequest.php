<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMedcineRequest extends FormRequest
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
            "enSciName"=>['sometimes','required'],
            "arSciName"=>['sometimes',  'required'],
            "enUseName"=>['sometimes','required', 'unique:medcines'],
            "arUseName"=>['sometimes','required'],
            "enCatigory"=>['sometimes', 'required'],
            "arCatigory"=>['sometimes','required'],
            "companyName"=>['sometimes', 'required'],
            "qtn"=>['sometimes', 'required'],
            "expiredDate"=>['sometimes', 'required'],
            "price"=> ['sometimes', 'required'],
            "description"=> ['sometimes', 'required'],
            "category_id"=>['sometimes','exists:categories,id']
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
