<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpenWeatherFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->validateRequestAgainstRules();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => 'required|string',
            '_token' => 'required'
        ];
    }

    /**
     * @return bool
     */
    private function validateRequestAgainstRules(): bool
    {
        $keys = collect($this->all())->keys();
        $response = collect($this->rules())->keys();

        return $keys->diff($response)->isEmpty();
    }
}
