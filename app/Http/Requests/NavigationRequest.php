<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NavigationRequest extends FormRequest
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
            'originX'      => 'required|numeric',
            'originY'      => 'required|numeric',
            'width'        => 'required|numeric',
            'height'       => 'required|numeric',
            'orientation'  => 'required|string',
            'instructions' => 'required|string',
        ];
    }

}
