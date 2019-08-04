<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContainerRequest extends FormRequest
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

    protected function validationData()
    {
        return $this->json()->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|unique:containers',
            'name' => 'string|max:255',
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.name' => 'string|max:255',
        ];
    }
}
