<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = ($this->segment(2) > 0) ? ',' . $this->segment(2) : '';
        $rules = [
            'name'  => 'required|max:255',
            'email' => 'required|max:255|unique:users,email' . $id,
            'role'  => 'required',
        ];

        if ($this->segment(2) < 1) {
            $rules['password'] = 'required|confirmed|min:6';
        } else {
            $rules['password'] = 'confirmed';
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
