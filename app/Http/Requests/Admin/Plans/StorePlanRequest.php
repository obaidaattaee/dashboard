<?php

namespace App\Http\Requests\Admin\Plans;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
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
            'name' => ['required'],
            'duration' => ['required', 'in:' . implode(',', array_column(Plan::DURATIONS, 'name'))],
            'cost' => ['required', 'numeric'],
            'is_quantable' => ['nullable', 'boolean'],
        ];
    }
}
