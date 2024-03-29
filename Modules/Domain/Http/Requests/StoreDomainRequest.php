<?php

namespace Modules\Domain\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
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
            'name'       => 'required|max:255',
            'url'        => 'required|regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/|max:255|unique:domains,url' . $id,
            'client_id' => 'required',
            'client_secret' => 'required',
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
