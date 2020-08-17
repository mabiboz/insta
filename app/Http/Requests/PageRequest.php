<?php

namespace App\Http\Requests;

use App\Models\CategoryPage;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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

    public function prepareForValidation()
    {

        $instapage_id = $this->request->get("instapage_id");
        if (substr($instapage_id, 0, 1) != "@") {
            $instapage_id = "@" . $instapage_id;
        }

        $this->request->add([
            "instapage_id" => $instapage_id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'instapage_id' => 'required|unique:pages,instapage_id',
            'state' => 'required',
            'all_members' => 'required',
            'fake_members' => 'required',
            'sex' => 'required',
            'age_contact' => 'required',

        ];
        if (!is_null($this->route('page'))) {
            $rules['instapage_id'] = 'required|unique:pages,instapage_id,' . $this->page->id;
        }


        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'وارد کردن عنوان صفحه الزامی می باشد .',
            'instapage_id.required' => 'آدرس صفحه را وارد نمایید .',
            'instapage_id.unique' => 'آدرس صفحه تکراری می باشد .',
            'state.required' => 'محدوده جغرافیایی فعالیت صفحه را مشخص نمایید .',
            'all_members.required' => 'تعداد کل فالوورهای را وارد نمایید .',
            'fake_members.required' => 'تعداد فالوورهای فیک را مشخص کنید .',
            'sex.required' => 'جنسیت مخاطبان خود را وارد نمایید .',
            'age_contact.required' => 'لطفا محدوده سنی مخاطبان خود را انتخاب نمایید .',


            //  'categorypage_id.required' => 'دسته بندی صفحه باید مشخص شود .',
//            'categorypage_id.in' => 'دسته بندی را به درستی انتخاب کنید .',
        ];
    }
}
