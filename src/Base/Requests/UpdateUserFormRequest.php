<?php

namespace Garavel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserFormRequest extends FormRequest {

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
        $userId = request()->route()->parameter('user');

        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $userId,
            'password' => 'nullable|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
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
            'name.required'  => 'İsim Soyisim mecburidir.',
            'email.required' => 'E-Posta adresi mecburidir.',
            'email.unique'   => 'Bu E-Posta adresi kullanılıyor.',
            'password.min'   => 'Şifre en az 6 karakterli olmalıdır',
            'password.regex' => 'Şifre en az birer adet küçük, büyük karakter ve rakam içermelidir',
        ];
    }
}
