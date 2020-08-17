<?php


namespace App\Helper;


use App\Models\Profit;
use App\Models\WalletLog;

class ProfitSharing
{
    public $page;
    public $ad;
    public $pageOwner;
    public $reagent;
    public $reagentLevel;
    public $percent_of_page_owner;
    public $percent_of_mabino;
    public $percent_of_reagent;
    public $fullPrice;

    public function __construct($page, $ad)
    {
        $this->ad = $ad;
        $this->page = $page;
        $this->pageOwner = $page->user;
        $this->reagent = $this->pageOwner->reagent;
        $this->fullPrice =  $this->page->price * getRatio($this->ad->day_count);
        if($this->ad->is_mabinoe){
            $this->fullPrice =  $this->page->price * getRatio($this->ad->day_count) / 2;

        }else{
            $this->fullPrice =  $this->page->price * getRatio($this->ad->day_count);
        }
        if ($this->reagent) {
            $this->reagentLevel = $this->reagent->agentRequest->agentLevel;
            $this->percent_of_mabino = $this->reagentLevel->mabino_percent / 100;
            $this->percent_of_page_owner = $this->reagentLevel->pageowner_percent / 100;
            $this->percent_of_reagent = $this->reagentLevel->my_percent / 100;
        } else {
            $this->reagentLevel = null;
            $this->percent_of_mabino = config("SharingConfig.PERCENT_OF_MABINO");
            $this->percent_of_page_owner = config("SharingConfig.PERCENT_OF_PAGE_OWNER");
            $this->percent_of_reagent = 0;
        }
    }


    public function forMabino()
    {
        Profit::create([
            "amount" => $this->fullPrice * $this->percent_of_mabino,
            "ad_id" => $this->ad->id,
            "page_id" => $this->page->id,
        ]);

    }


    public function forPageOwner()
    {
        $portion_of_page_owner = $this->fullPrice * $this->percent_of_page_owner;

        //charge wallet page owner

        $this->pageOwner->wallet->update([
            'sum' => $this->pageOwner->wallet->sum + $portion_of_page_owner,
        ]);

        WalletLog::create([
            'user_id' => $this->pageOwner->id,
            'price' => $portion_of_page_owner,
            'method_create' => WalletLog::DIVIDEND,
            'wallet_operation' => WalletLog::INCREMENT,
        ]);
    }


    public function forReagent()
    {
        if($this->reagent){
            $portion_of_reagent = $this->fullPrice * $this->percent_of_reagent;

            $this->reagent->wallet->update([
                'sum' => $this->reagent->wallet->sum + $portion_of_reagent,
            ]);

            WalletLog::create([
                'user_id' => $this->reagent->id,
                'price' => $portion_of_reagent,
                'method_create' => WalletLog::FROM_MYADMIN,
                'wallet_operation' => WalletLog::INCREMENT,
            ]);


        }
    }


}