<?php

namespace App\Http\Requests\Admin\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'client_id' => ['required', 'exists:clients,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'start_from' => ['required', 'date', 'date_format:Y-m-d'],
            'expiration_date' => ['required', 'date', 'date_format:Y-m-d'],
            'cost' => ['required', 'numeric'],
            'description' => ['nullable'],
            'quantity' => ['nullable', 'numeric']
        ];
    }
}
