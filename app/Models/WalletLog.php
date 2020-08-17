<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletLog extends Model
{

    protected $table='wallet_log';
    protected $guarded=[
        'id'
    ];

    const ONLINE =1;
    const MABINO =2; // درخواست وجه از مابینو
    const DIVIDEND =3; // سود تسهیم
    const ADD_AD =4;
    const ABORT_AD =5; //برگشت پول به کیف پول در صورت رد آگهی توسط پیج دار
    const TASHVIGHI =6; //تشویقی به صورت دستی اضافه شود .
    const EXPIRE_AD =7; //منقضی شدن آگهی .
    const FROM_MYADMIN =8;
    const CONVERT_TO_AGENT =9;
    const NOT_VERIFIED_REAGENT =10;







    const DECREMENT =0;
    const INCREMENT =1;


    public static function getMethodWalletCreate()
    {
        return [
            self::ONLINE =>'واریز آنلاین',
            self::MABINO =>'درخواست وجه',
            self::DIVIDEND =>'سود تسهیم',
            self::ADD_AD =>'ثبت آگهی',
            self::ABORT_AD =>'رد شدن آگهی توسط پیج دار',
            self::TASHVIGHI =>'اضافه شده توسط مابینو',
            self::EXPIRE_AD=>'منقضی شدن آگهی',
            self::FROM_MYADMIN=>'سود حاصل از عملکرد ادمین',
             self::CONVERT_TO_AGENT=>'هزینه اخذ نمایندگی',
            self::NOT_VERIFIED_REAGENT=>'بازگشت پول - عدم تایید درخواست نمایندگی',

        ];
    }


    public static function getWalletOperation()
    {
        return [
            self::DECREMENT =>'-',
            self::INCREMENT =>'+'
        ];
    }





    /*relations*/
    //relation with user
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
