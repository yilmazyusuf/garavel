<?php

namespace Garavel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionFormRequest extends FormRequest {

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
        $permissionId = request()->route()->parameter('permission');

        return [
            'name'    => 'required|unique:permissions,name,'.$permissionId,
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
            'name.required'  => 'Yetki ismi belirtmelisiniz.',
            'name.unique'  => 'Bu yetki ismi kullanılıyor.',
        ];
    }
}
