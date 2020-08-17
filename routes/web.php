<?php


Route::get("/img", function () {
    $url = "https://www.instagram.com/p/B135LU3gJL8/";

    $screen_shot_image = '';

    $screen_shot_json_data = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$url&screenshot=true");
    $screen_shot_result = json_decode($screen_shot_json_data, true);
    $screen_shot = $screen_shot_result['screenshot']['data'];
    $screen_shot = str_replace(array('_', '-'), array('/', '+'), $screen_shot);
    $screen_shot_image = "<img src=\"data:image/jpeg;base64," . $screen_shot . "\" class='img-responsive img-thumbnail'/>";

    return view("test",compact("screen_shot_image"));
});


//Route::get('/login',function(){
//  return view('index');
//
//});
// Route::get('/ss',function(){
// \Auth::loginUsingId(313);

// });

// use App\Models\Page;

// Route::get("/kb", function () {
//     $pages=  \App\Models\PageLastVersion::all();
//     foreach ($pages as $page){
//         $page->update([
//             'page_id'=>$page->id,
//         ]);
//     }


// });


// Route::get('/changeplantob',function(){

//     $pages=\App\Models\Page::where('plan','a')->where('status',1)->get();
//   $cnt=0;
//     foreach ($pages as $page){
//         if(is_null($page->pagedetail)){
// $page->update([
//     'plan'=>'b'
// ]);
// $cnt++;
//         }
//         }
//         dd('ok',$cnt);

// });


Route::get('/ghavanin', function () {
    return view('user.dashboard.roles');

})->name('ghavanin');

/*routes for reset password*/
Route::group(['prefix' => 'resetPassword', 'namespace' => 'Auth'], function () {
    Route::get('/getMobile/showForm', 'MobileResetPassword@showFormGetMobile')->name('resetPassword.showFormGetMobile');
    Route::get('/getMobile', 'MobileResetPassword@getMobile')->name('resetPassword.getMobile');
    Route::get('/getMobile/verifyMobile', 'MobileResetPassword@verifyMobile')->name('resetPassword.verifyMobile');
    Route::post('done', 'MobileResetPassword@resetPassword')->name('resetPassword.done');

});

/*route for change Password*/
Route::group(['namespace' => 'Auth', 'middleware' => "auth"], function () {
    Route::post("/changePassword", "ChangePasswordController@change")->name("changePassword");
});


/*route for link reagent for register*/
Route::get('/rg/{code}', function ($code) {
    return redirect("/register?code=" . $code);
})->name('registerWithLinkFromAgent');

Route::get('/', function () {
    return view('home');
    return redirect('/login');
});


Auth::routes();
Route::get('logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
});

Route::get('/getCity', 'Auth\RegisterController@getCity')->name('getCity');


/*user panel Routes*/
Route::group(['middleware' => ['auth', 'checkUserRole']], function () {
    Route::get('user/dashboard', 'User\DashboardController@index')->name('user.dashboard');
    Route::post('user/activation', 'User\DashboardController@activation')->name('user.activation');
    Route::post('user/acceptRules', 'User\DashboardController@acceptRules')->name('user.acceptRules');

});

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth', 'user']], function () {

    /*tutorial route*/
    Route::get('/tutorial/adminPage', "TutorialsController@adminPage")->name('user.tutorial.adminPage');
    Route::get('/tutorial/agent', "TutorialsController@agent")->name('user.tutorial.agent');
    Route::get('/tutorial/user', "TutorialsController@user")->name('user.tutorial.user');
    Route::get('/tutorial/publicTutorial', "TutorialsController@publicTutorial")->name('user.tutorial.publicTutorial');


    Route::get('/ad/file/download/{file}', function ($file) {
        return Illuminate\Support\Facades\Response::download(public_path(config('UploadPath.ad_image_path')) . $file);
    })->name('user.ad.file.download');


    /*Route for set auto send*/
    Route::group(['prefix' => "autoSend"], function () {
        Route::get('/', "AutoSendController@create")->name('user.autosend.create');
        Route::post('/update', "AutoSendController@update")->name('user.autosend.update');
    });


    /*Route for request agent from dashboard*/
    Route::group(['prefix' => "/dashboard/agentRequest"], function () {
        Route::post('/prefactor', "DashboardController@prefactor")->name('user.dashboard.agentRequest.prefactor');
        Route::get('/payment/{agentLevel}', "DashboardController@payment")->name('user.dashboard.agentRequest.payment');
        Route::any('/payback/{agentLevel}', "DashboardController@payback")->name('user.dashboard.agentRequest.payback');

    });


    Route::group(['prefix' => 'userDetail'], function () {
        Route::get('/getDetail', 'UserDetailsController@getDetail')->name('user.getUserDetail');
        Route::post('/addDetail', 'UserDetailsController@addDetail')->name('user.addUserDetails');

    });


    Route::group(['prefix' => 'pageDetail'], function () {
        Route::post('/addDetail', 'PagedetailController@addDetail')->name('user.pagedetails.setDetailAjax');
        Route::post('/addDetail/edit', 'PagedetailController@edit')->name('user.pagedetails.edit');

    });


    /*request to Convert Agent*/
    Route::post('/selectAgentLevel/convertToAgent', 'RequestConvertAgentController@selectAgentLevel')->name('user.selectAgentLevel');
    Route::get('/convertToAgent', 'RequestConvertAgentController@requestConvertToAgent')->name('user.requestConvertToAgent');


    /*instagram page Route*/
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/', 'PagesController@index')->name('user.pages.index');
        Route::get('/create', 'PagesController@create')->name('user.pages.create');
        Route::post('/store', 'PagesController@store')->name('user.pages.store');
        Route::get('/edit/{page}', 'PagesController@edit')->name('user.pages.edit');
        Route::post('/update/{page}', 'PagesController@update')->name('user.pages.update');

        Route::get('/publication/changestate/{page}', 'PagesController@publicationchange')->name('user.publication.change');

        Route::get('/getCity', 'PagesController@getCity')->name('user.pages.getCity');
        Route::post('/getReasonAbort', 'PagesController@getReasonAbort')->name('user.pages.getReasonAbort');

    });


    /*user wallet Route*/
    Route::group(['prefix' => 'wallet'], function () {
        Route::post('/charge/pay', 'WalletsController@pay')->name('user.wallet.charge.pay');
        Route::any('/charge/payback', 'WalletsController@payback')->name('user.wallet.charge.payback');
    });

    /*user walletLog Route*/
    Route::group(['prefix' => 'walletLog'], function () {
        Route::get('/', 'WalletLogsController@index')->name('user.walletLog.index');
        Route::post('/getDescription', 'WalletLogsController@getDescription')->name('user.walletLog.getDescription');


    });


    /*user PayRequest Route*/
    Route::group(['prefix' => 'PayRequest'], function () {
        Route::post('/', 'PayRequestController@PayRequest')->name('user.PayRequest');
        Route::get('all', 'PayRequestController@all')->name('user.PayRequest.all');
        Route::get('pending', 'PayRequestController@pending')->name('user.PayRequest.pending');


    });


    /*campain Route*/
    Route::group(['prefix' => 'campain'], function () {
        Route::get('/index', 'UserCampainsController@index')->name('user.campain.index');
        Route::post('/getDescription/{id}', 'UserCampainsController@getDescription')->name('user.campain.getDescription');
        Route::post('/getCampainPagesAjax', 'UserCampainsController@getCampainPagesAjax')->name('user.campain.getCampainPagesAjax');
        Route::get('/create', 'UserCampainsController@create')->name('user.campain.create');
        Route::post('/getPages', 'UserCampainsController@getPages')->name('user.campain.getPages');
        Route::post('/invoice', 'UserCampainsController@invoice')->name('user.campain.invoice');
        Route::post('/store', 'UserCampainsController@store')->name('user.campain.store');
        Route::post('/ajaxValidation', 'UserCampainsController@ajaxValidation')->name('user.campain.ajaxValidation');
        Route::post('/addToFav', 'UserCampainsController@addToFav')->name('user.campain.addToFav');

        Route::post('/getDataFromFavoriteList', 'UserCampainsController@getDataCampainFromFavoriteList')->name('user.campain.getDataFromFavoriteList');

        Route::post('/getDataFromFavoriteListAndPutToForm', 'UserCampainsController@getDataFromFavoriteListAndPutToForm')->name('user.campain.getDataFromFavoriteListAndPutToForm');


    });

    /*adRequest For AdminPageOwner*/
    Route::group(['prefix' => 'ad'], function () {
        Route::post("/request/changeState", "AdsController@changeState")->name("user.requestAd.changeState");

        Route::post("/request/showDetails", "AdsController@showDetails")->name("user.requestAd.showDetails");
    });


    /*ticket messaging routes*/
    Route::group(['prefix' => 'tickets'], function () {
        Route::get('', 'TicketMessagesController@index')->name('user.ticket.list');
        Route::get('/create', 'TicketMessagesController@create')->name('user.ticket.create');
        Route::post('store', 'TicketMessagesController@store')->name('user.ticket.store');
        Route::post('showContent', 'TicketMessagesController@showContent')->name('user.ticket.showContent');
        Route::post('getAnswers', 'TicketMessagesController@getAnswers')->name('user.ticket.getAnswers');
    });


    /*Route for My ads list*/
    Route::get('/myAds', 'AdsController@myAds')->name('user.panel.myAds');


    /*news routes*/
    Route::group(['prefix' => 'news'], function () {
        Route::get('', 'NewsController@index')->name('user.news.list');
        Route::post('/detail', 'NewsController@detail')->name('user.news.detail');
    });

    /*planB Ad routes*/
    Route::group(['prefix' => 'planB_ad'], function () {
        Route::get('list', 'PlanBAdsController@index')->name('user.planB.ad.list');
        Route::post('registerLink', 'PlanBAdsController@registerLink')->name('user.planB.ad.registerLink');

    });


});
/*end user panel Routes*/


/* admin panel routes*/


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'mabino']], function () {


    /*tutorials Route*/
    Route::group(['prefix' => 'tutorial'], function () {
        Route::get('create', 'TutorialsController@create')->name('admin.tutorial.create');
        Route::post('store', 'TutorialsController@store')->name('admin.tutorial.store');

    });

    Route::get('/visitedPage', 'VisitsController@index')->name('admin.visitedPage.index');


    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');


    Route::get('/pagesnotverified', 'PageController@pagesnotverified')->name('admin.pagesnotverified');
    Route::get('/pagesverified', 'PageController@pagesverified')->name('admin.pagesverified');
    Route::get('/page/all', 'PageController@all')->name('admin.page.all');
    Route::get('/pages/planB/list', "PageController@planB_list")->name("admin.pages.planB.list");
    Route::get('/pages/planA/list', "PageController@planA_list")->name("admin.pages.planA.list");


    Route::post('/page/changestate', 'PageController@changestate')->name('admin.page.changestate');
    Route::post('/page/getDetailsAjax', 'PageController@getDetailsAjax')->name('admin.page.getDetailsAjax');
    Route::get('/page/delete/{page}', 'PageController@delete')->name('admin.pages.delete');
    Route::get('/page/edit/{page}', 'PageController@edit')->name('admin.pages.edit');
    Route::post('/page/update/{page}', 'PageController@update')->name('admin.pages.update');
    Route::get('/page/sendAdFromMabino/{page}', 'PageController@sendAdFromMabino')->name('admin.pages.sendAdFromMabino');


    Route::get('/users/list', 'UsersController@usersList')->name('admin.users.list');
    Route::get('/agents/list', 'UsersController@agentsList')->name('admin.agents.list');
    Route::post('/user/changestate', 'UsersController@changestate')->name('admin.user.changestate');
    Route::post('/user/payrequest/list/{id}', 'UsersController@payrequestList')->name('admin.user.payrequest.list');
    Route::post('/user/tickets', 'UsersController@ticketList')->name('admin.user.ticketList');
    Route::post('/user/parentAndChild', 'UsersController@parentAndChild')->name('admin.user.parentAndChild');
    Route::post('/user/walletLogs', 'UsersController@walletLogs')->name('admin.user.walletLogs');

    Route::post('/user/edit', 'UsersController@edit')->name('admin.user.edit');
    Route::post('/user/update/{user}', 'UsersController@update')->name('admin.user.update');
    Route::post('/user/pages', 'UsersController@pages')->name('admin.user.pages');
    Route::post('/user/adminsOfAgent', 'UsersController@adminsOfAgent')->name('admin.user.adminsOfAgent');


    Route::get('/ad/list', 'AdController@adlist')->name('admin.ad.list');
    Route::get('/ad/notVerified', 'AdController@notVerified')->name('admin.ad.notVerified');
    Route::post('/ad/changestate', 'AdController@changestate')->name('admin.ad.changestate');
    Route::get('/ad/delete/{ad}', 'AdController@delete')->name('admin.ad.delete');

    Route::post('/wallet/chargeform/{user_id}', 'WalletController@showchargeform')->name('admin.wallet.charge');
    Route::post('/wallet/charge/{user_id}', 'WalletController@charge')->name('admin.user.wallet.charge');

    Route::post('/admin/user/campainList/{user_id}', 'UsersController@campainList')->name('admin.user.campain.list');
    Route::post('/admin/user/campain/getPages/{id}/{userid}', 'UsersController@getCampainPagesAjax')->name('admin.user.campain.getCampainPagesAjax');

    Route::get('/profit', 'ProfitController@all')->name('admin.profit.all');
    Route::get('/transactions', 'TransactionsController@all')->name('admin.transaction.all');


    /*user PayRequest Route*/
    Route::group(['prefix' => 'PayRequest'], function () {
        Route::get('all', 'PayRequestController@all')->name('admin.PayRequest.all');
        Route::get('pending', 'PayRequestController@pending')->name('admin.PayRequest.pending');
        Route::post('pay', 'PayRequestController@pay')->name('admin.PayRequest.pay');

    });
    /*categoryPages*/
    Route::group(['prefix' => 'categoryPages'], function () {
        Route::get('/', 'CategoryPagesController@index')->name('admin.categoryPage.index');
        Route::post('/store', 'CategoryPagesController@store')->name('admin.categoryPage.store');
        Route::get('/edit/{category}', 'CategoryPagesController@edit')->name('admin.categoryPage.edit');
        Route::post('/update/{category}', 'CategoryPagesController@update')->name('admin.categoryPage.update');
    });

    /*request for convert To Agent*/
    Route::group(['prefix' => 'agentRequests'], function () {
        Route::get('/', 'AgentRequestsController@index')->name('admin.agentRequests.index');
        Route::post('/changeState', 'AgentRequestsController@changeState')->name('admin.agentRequests.changeState');

    });


    /*tickets route*/
    Route::group(['prefix' => 'tickets'], function () {
        Route::get('/', 'TicketsController@index')->name('admin.ticket.index');
        Route::get('/close/{boxMessaging}', 'TicketsController@close')->name('admin.ticket.close');
        Route::post('/detailAndShowFormAnswer', 'TicketsController@detailAndShowFormAnswer')->name('admin.ticket.detailAndShowFormAnswer');
        Route::post('/registerAnswer/{ticket}', 'TicketsController@registerAnswer')->name('admin.ticket.registerAnswer');
    });

    /*export data route*/
    Route::group(['prefix' => 'export'], function () {
        Route::get('/users', 'ExcelsController@users')->name('admin.export.users');
        Route::get('/pageOwners', 'ExcelsController@pageOwners')->name('admin.export.pageOwners');
        Route::get('/agents', 'ExcelsController@agents')->name('admin.export.agents');
        Route::get('/PageOwnerWithoutDetail', 'ExcelsController@PageOwnerWithoutDetail')->name('admin.export.PageOwnerWithoutDetail');

    });

    /*sms logs*/
    Route::group(['prefix' => 'smsLogs'], function () {
        Route::get('/index', 'SmsLogsController@index')->name('admin.smsLog.index');
        Route::get('/verify', 'SmsLogsController@verify')->name('admin.smsLog.verify');

    });


    /*agentLevels route*/
    Route::group(['prefix' => 'agentLevel'], function () {
        Route::get('/index', 'AgentLevelsController@index')->name('admin.agentLevel.index');
        Route::post('/store', 'AgentLevelsController@store')->name('admin.agentLevel.store');
        Route::get('/edit/{agentLevelItem}', 'AgentLevelsController@edit')->name('admin.agentLevel.edit');
        Route::post('/update/{agentLevelItem}', 'AgentLevelsController@update')->name('admin.agentLevel.update');
        Route::get('/changeStatus/{agentLevelItem}', 'AgentLevelsController@changeStatus')->name('admin.agentLevel.changeStatus');
    });


    /*send ad from mabino routes*/
    Route::group(['prefix' => 'newAdFromMabino'], function () {

        Route::get('/create', 'NewAdsController@create')->name('admin.newAdFromMabino.create');
        Route::post('/store', 'NewAdsController@store')->name('admin.newAdFromMabino.store');
        Route::get('/delete/{ad}', 'NewAdsController@delete')->name('admin.newAdFromMabino.delete');
        Route::get('/changeStatus/{ad}', 'NewAdsController@changeStatus')->name('admin.newAdFromMabino.changeStatus');


    });


    /*mabino campains route*/

    Route::group(['prefix' => 'mabinoCampain'], function () {
        Route::get('/index', 'MabinoCampainsController@index')->name('admin.mabinoCampain.index');
        Route::post('/getDescription/{id}', 'MabinoCampainsController@getDescription')->name('admin.mabinoCampain.getDescription');
        Route::post('/getCampainPagesAjax', 'MabinoCampainsController@getCampainPagesAjax')->name('admin.mabinoCampain.getCampainPagesAjax');

        Route::get('/planBAd/listAndCheckout/{ad}/{date}', 'MabinoCampainsController@PlanBAdlistAndCheckout')->name('admin.mabinoCampain.PlanBAdlistAndCheckout');

    });


    /*mabinoWallet  route*/

    Route::group(['prefix' => 'mabinoWallet'], function () {
        Route::get('/mabinoWalletCharge', 'MabinoWalletController@mabinoWalletCharge')->name('admin.mabinoWalletCharge');
        Route::get('/mabinoWalletLog', 'MabinoWalletController@mabinoWalletLog')->name('admin.mabinoWalletLog');
    });


    /*news route*/
    Route::group(['prefix' => 'news'], function () {
        Route::get('/index', 'NewsController@index')->name('admin.news.index');
        Route::post('/store', 'NewsController@store')->name('admin.news.store');
        Route::get('/delete/{news}', 'NewsController@delete')->name('admin.news.delete');
    });

    /*planB Ad routes*/
    Route::group(['prefix' => 'planBAd'], function () {
        Route::get('/list', 'PlanBAdsController@list')->name('admin.planB.Ad.list');
        Route::get('/list/checkouted', 'PlanBAdsController@checkouted')->name('admin.planB.Ad.checkouted.list');
        Route::get('/checkout/{ad}/{page}', 'PlanBAdsController@checkout')->name('admin.planB.Ad.checkout');
        Route::post('/statistics/edit', 'PlanBAdsController@statisticsEdit')->name('admin.planB.Ad.statisticsEdit');
        Route::post('/statistics/update', 'PlanBAdsController@statisticsUpdate')->name('admin.planB.Ad.statisticsUpdate');

    });


    /*user campains route*/

    Route::group(['prefix' => 'userCampain'], function () {
        Route::get('/index', 'UserCamapinsController@index')->name('admin.userCampain.index');
        Route::post('/getDescription/{id}', 'UserCamapinsController@getDescription')->name('admin.userCampain.getDescription');
        Route::post('/getCampainPagesAjax', 'UserCamapinsController@getCampainPagesAjax')->name('admin.userCampain.getCampainPagesAjax');
        Route::get('/planBAd/listAndCheckout/{campain}', 'UserCamapinsController@PlanBAdlistAndCheckout')->name('admin.userCampain.PlanBAdlistAndCheckout');


    });


});


/* end admin panel routes*/


/*routes reagent*/
Route::group(['prefix' => 'agents', 'namespace' => 'Agent', 'middleware' => ['auth', 'agent']], function () {

    Route::get('/reagentCode', 'ReagentCodeController@show')->name('agent.code.show');

    /*agent admins Route*/
    Route::group(['prefix' => 'admins'], function () {
        Route::get('/', "AdminsController@index")->name('agent.admin.index');
        Route::get('/create', "AdminsController@create")->name('agent.admin.create');
        Route::post('/store', "AdminsController@store")->name('agent.admin.store');
        Route::get('/getCity', "AdminsController@getCity")->name('agent.admin.getCity');
        Route::post('/reportAct', "AdminsController@reportAct")->name('agent.admin.reportAct');
    });

});
/*end routes reagent*/



