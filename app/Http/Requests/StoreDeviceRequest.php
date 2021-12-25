<?php

namespace Boykioyb\Notify\Http\Requests;

use App\Http\Requests\Request;


/**
 * Class StoreDeviceRequest
 * @package Boykioyb\Notify\Http\Requests
 */
class StoreDeviceRequest extends Request
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
            'token' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'token.required' => trans('validation.required'),
        ];
    }

}
