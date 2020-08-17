<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    const ROLE_USER = 1;
    const ROLE_AGENT = 2;
    const ROLE_MABINO = 3;


    const UNVERIFIED = 0;
    const VERIFIED_AND_NOT_ACCEPT_RULE = 1;
    const VERIFIED_AND_ACCEPT_RULE = 2;

    const INACTIVE = 0;
    const ACTIVE = 1;

    const BISAVAD = 1;
    const CYCLE = 2;
    const DIPLOM = 3;
    const LISANS = 4;
    const FOGHLISANS = 5;
    const DOCTORA = 6;

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function getEducationLevel($key = null)
    {
        $levels = [
            self::BISAVAD => "بی سواد",
            self::CYCLE => "سیکل",
            self::DIPLOM => "دیپلم",
            self::LISANS => "لیسانس",
            self::FOGHLISANS => "فوق لیسانس",
            self::DOCTORA => "دکترا",
        ];

        if (is_null($key)) {
            return $levels;
        }
        return $levels[$key];
    }


    /*relations*/

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function getHasPlanBAttribute()
    {
        if (Auth::check() and Auth::user()->is_admin) {
            $users_id = User::whereHas("pages", function ($q) {
                $q->where("plan", "b");
            })->pluck('id')->toArray();

            if (in_array(Auth::user()->id, $users_id)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function getPlanAPagesAttribute()
    {
       $pages = Auth::user()->pages()->where("plan","a")->get();
       return $pages;
    }

    public function getPlanBPagesAttribute()
    {
        $pages = Auth::user()->pages()->where("plan","b")->get();
        return $pages;
    }


    public function walletlogs()
    {
        return $this->hasMany(WalletLog::class, 'user_id');
    }

    public function campains()
    {
        return $this->hasMany(Campain::class, "user_id");
    }


    public function payRequests()
    {
        return $this->hasMany(PayRequest::class, "user_id")->latest();
    }

    public function ticketMessagings()
    {
        return $this->hasMany(TicketMessaging::class, "user_id");

    }

    public function agentRequest()
    {
        return $this->hasOne(AgentRequest::class, "user_id");
    }

    public function favoriteAds()
    {
        return $this->hasMany(FavoriteAd::class, "user_id");
    }

    public function reagent()
    {
        return $this->belongsTo(User::class, "reagent_id");
    }

    public function reagentUsers()
    {
        return $this->hasMany(User::class, "reagent_id");
    }

    public function city()
    {
        return $this->belongsTo(City::class, "city_id");
    }





    /*end relations*/


    public function getNewAdRequestForPagesAttribute()
    {
        $pages = $this->pages()->where("status", Page::ACTIVE)->get();
        $result = [];
        foreach ($pages as $page) {
            $result[$page->id] = [];
            $campains = $page->campains()->wherePivot("status", Page::PAGE_CAMPAIN_PIVOT_STATUS_PENDING)->get();
            $ad_temp = collect();
            foreach ($campains as $campain) {
                $timeToExpired = $campain->created_at->addHours($campain->deadline);
                if (Carbon::now()->lessThan($timeToExpired)) {
                    $ad_temp = $ad_temp->merge($campain->ads()->where("status", Ad::OK)->get());
                }
            }

            $result[$page->id] = $ad_temp;

        }

        return $result;
    }


    public function getAdRequestForPagesAttribute()
    {
        $pages = $this->pages()->where("status", Page::ACTIVE)->get();
        $result = [];
        foreach ($pages as $page) {
            $result[$page->id] = [];
            $campains = $page->campains()->wherePivot("status", "!=", Page::PAGE_CAMPAIN_PIVOT_STATUS_FAILED)->get();
            $ad_temp = collect();
            foreach ($campains as $campain) {
                $timeToExpired = $campain->created_at->addHours($campain->deadline);
                if (Carbon::now()->lessThan($timeToExpired)) {
                    $ad_temp = $ad_temp->merge($campain->ads()->where("status", Ad::OK)->get());
                }
            }

            $result[$page->id] = $ad_temp;

        }


        return $result;
    }

}
