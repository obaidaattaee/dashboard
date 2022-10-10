<?php

namespace App\Http\Requests\Admin\Clients;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            "company_name" => ['nullable'],
            "email" => ['nullable'],
            "company_phone" => ['nullable'],
            "admin_name" => ['nullable'],
            "admin_phone" => ['nullable'],
            'logo_image' => ['nullable' , 'mimes:png,jpeg,jpg,gif']
        ];
    }
}
