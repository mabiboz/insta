<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 02/06/2019
 * Time: 02:51 PM
 */

namespace App\Helper;


use App\Models\WalletLog;

class PayWalletAndLog
{
    private $price;
    private $user;
    private $wallet;
    private $method_create;


    public function __construct($price, $user,$method_create)
    {
        $this->price = $price;
        $this->user = $user;
        $this->wallet = $user->wallet;
        $this->method_create = $method_create;
    }

    public function decrease()
    {
        if ($this->wallet->sum < $this->price) {
            return ["result" => 0, "message" => "مبلغ کیف پول کافی نمی باشد ."];
        }

        $resultUpdate = $this->wallet->update([
            "sum" => $this->wallet->sum - $this->price,
        ]);
        if($resultUpdate){
            WalletLog::create([
                'user_id'=>$this->user->id,
                'price' => $this->price,
                'method_create' => $this->method_create,
                'wallet_operation' =>WalletLog::DECREMENT,
            ]);
            return  ["result" => 1, "message" => "با موفقیت انجام شد !"];
        }

        return  ["result" => 0, "message" => "مشکلی در عملیات رخ داده !"];
    }


}