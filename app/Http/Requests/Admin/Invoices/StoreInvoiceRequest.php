<?php

namespace App\Http\Requests\Admin\Invoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'invoice_number' => ['required', 'string'],
            'description' => ['nullable'],
            'duration' => ['required', 'numeric'],
            'invoice_image' => ['nullable', 'mimes:png,jpg,jpeg'],
            'invoice_cost' => ['nullable', 'numeric']
        ];
    }
}
