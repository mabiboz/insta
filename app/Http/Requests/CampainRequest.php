<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CampainRequest extends FormRequest
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
        $favoriteAd_id = Request::capture()->isAddDataFromFavoriteList;

        $rules = [
            'pages_id' => 'required',
            'campain_name' => 'required',
            'ad_content' => 'required|max:960',
            'dayCount' => 'required|numeric|min:1|max:3',
            'expired_at' => 'required',
//            'ad_image' => 'required|file',
        ];

        if ($favoriteAd_id == 0) {
            $rules['ad_image'] = 'required|file';
        }else{
            $rules['ad_image'] = 'nullable|file';
        }
        return $rules;

    }

    public function messages()
    {
        return [
            'pages_id.required' => 'لطفا صفحات اینستاگرام را انتخاب کنید .',
            'campain_name.required' => 'نام کمپین را وارد کنید .',
            'ad_content.required' => 'محتوای آگهی را وارد نمایید .',
            'ad_content.max' => 'محتوای آگهی نباید بیشتر از 960 کارکتر باشد .',
            'dayCount.required' => 'تعداد روز انتشار آگهی را مشخص کنید .',
            'dayCount.min' => 'حداقل تعداد روز انتشار ، یک روز می باشد .',
            'dayCount.max' => 'حداکثر تعداد روز انتشار ، سه روز می باشد .',
            'expired_at.required' => 'مهلت پذیرش آگهی توسط پیج دارها باید مشخص شود .',
            'ad_image.file' => 'لطفا فایل خود را آپلود نمایید .',
            'ad_image.required' => 'لطفا فایل خود را آپلود نمایید .',
        ];

    }
}
