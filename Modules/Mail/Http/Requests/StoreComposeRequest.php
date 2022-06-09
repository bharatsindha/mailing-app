<?php

namespace Modules\Mail\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComposeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

//        dd(request()->all());
        return [
            'domain_id'    => 'required',
            'email_id'     => 'required',
            'excelFile'    => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/excel',
            'subject'      => 'required',
            'mail_content' => 'required',
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
