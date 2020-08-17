<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = ['id'];

    const INACTIVE = 0;
    const ACTIVE = 1;


    const FEMALE =0;
    const MALE =1;
    const BOTH =2;

    const ALL_AGE =1;
    const LESS_THAN_18 =2;
    const BETWEEN_18_40 =3;
    const GREATER_THAN_40 =4;

    /*relations*/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoryPage()
    {
        return $this->belongsTo(CategoryPage::class, 'categorypage_id');
    }

    public function campains()
    {
        return $this->belongsToMany(Campain::class)->withPivot("status");
    }

    public function city()
    {
        return $this->belongsTo(Province::class,"city_id");
    }

    public function pageRequest()
    {
        return $this->hasMany(PageRequest::class,'page_id');
    }
    public function pagedetail()
    {
        return $this->hasOne(PageDetail::class, "page_id");
    }
    
        public function pagesLastVersion()
    {
        return $this->hasMany(PageLastVersion::class);
    }
    /*end relations*/

    public static function getSexPage()
    {
        return [
            self::FEMALE => "بانوان",
            self::MALE => "آقایان",
            self::BOTH => "عمومی",
        ];
    }

    public static function getContactAge()
    {
        return [
            self::ALL_AGE => "همه مخاطبان",
            self::LESS_THAN_18 => "مخاطبان کمتر از 18 سال",
            self::BETWEEN_18_40 => "مخاطبان 18 تا 40 سال",
            self::GREATER_THAN_40 => "مخاطبان بیشتر از 40 سال",
        ];
    }




}
