<?php

namespace Garavel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleFormRequest extends FormRequest {

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
        $roleId = request()->route()->parameter('role');

        return [
            'name'    => 'required|unique:roles,name,'.$roleId,
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
            'name.required'  => 'Rol ismi belirtmelisiniz.',
            'name.unique'  => 'Bu rol ismi kullanılıyor.',
        ];
    }
}
