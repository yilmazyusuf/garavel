<?php

namespace Garavel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingFormRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //@todo Auth
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
            'title' => 'required',
            'key'   => 'required',
            'value' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Başlık belirtmelisiniz.',
            'key.required' => 'Ayar adı belirtmelisiniz.',
            'value.required' => 'Ayar değeri belirtmelisiniz.',
        ];
    }
}
