<?php

namespace Modules\Email\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = ($this->segment(2) > 0) ? ',' . $this->segment(2) : '';
        return [
            'domain_id'    => 'required',
            'sender_name'  => 'required',
            'sender_email' => 'required|max:255|unique:emails,sender_email' . $id,
        ];
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
