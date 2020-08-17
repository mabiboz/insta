<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentLevelRequest extends FormRequest
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
            'title'=>'required',
            'price'=>'required|numeric',
            'mabino_percent'=>'required|numeric',
            'agent_percent'=>'required|numeric',
            'admin_percent'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'عنوان را وارد نمایید .',
            'price.required'=>'قیمت الزامی می باشد .',
            'price.numeric'=>'فرمت قیمت صحیح نمی باشد .',
            'mabino_percent.required'=>'درصد مابینو را مشخص نمایید .',
            'mabino_percent.numeric'=>'فرمت درصد مابینو صحیح نمی باشد .',
            'agent_percent.required'=>'درصد نمایندگی را مشخص نمایید .',
            'agent_percent.numeric'=>'فرمت درصد نمایندگی صحیح نمی باشد .',
            'admin_percent.required'=>'درصد ادمین را مشخص نمایید .',
            'admin_percent.numeric'=>'فرمت درصد ادمین صحیح نمی باشد .',
        ];
    }

}
