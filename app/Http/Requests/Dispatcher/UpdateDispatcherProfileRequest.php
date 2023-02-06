<?php

namespace App\Http\Requests\Dispatcher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDispatcherProfileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'sometimes|required',
            'mobile'=>'sometimes|required',
            'email'=>'sometimes|required|email'
        ];
    }
}
