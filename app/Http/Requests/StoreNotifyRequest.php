<?php

namespace Boykioyb\Notify\Http\Requests;

use App\Http\Requests\Request;


class StoreNotifyRequest extends Request
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
            'title' => 'required',
            'description' => 'required',
            'receiver_type' => 'required',
            //'receiver_id' => 'required',
            'action' => 'required',
            //'content' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => trans('validation.required'),
            'description.required' => trans('validation.required'),
            'receiver_type.required' => trans('validation.required'),
            'receiver_id.required' => trans('validation.required'),
            'action.required' => trans('validation.required'),
            'content.required' => trans('validation.required'),
        ];
    }

}
