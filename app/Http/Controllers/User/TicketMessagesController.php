<?php

namespace App\Http\Controllers\User;

use App\Models\BoxMessaging;
use App\Models\TicketMessaging;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketMessagesController extends Controller
{
    public function index()
    {
        $box_ids = array_keys(Auth::user()->ticketMessagings->groupBy('box_id')->toArray());
        $boxMessages = BoxMessaging::find($box_ids);
        return view("user.ticketMessage.index", compact("boxMessages"));
    }

    public function create()
    {
        return view("user.ticketMessage.create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "content" => "required",
        ], [
            "title.required" => "عنوان تیکت الزامی می باشد !",
            "content.required" => "محتوا تیکت را وارد نمایید !",
        ]);


        if (!$request->has("box_id")) {
            $boxMessaging = BoxMessaging::create([
                "status" => BoxMessaging::OPEN,
                "title" => $request->input('title'),
            ]);
        } else {
            $boxMessaging = BoxMessaging::find($request->box_id);
            if($boxMessaging->status == BoxMessaging::CLOSED){
                flash_message("متاسفانه تیکت موردنظر بسته شده است !","danger");
                return back();
            }
        }


        $newTicket = TicketMessaging::create([
            "content" => $request->input('content'),
            "status" => TicketMessaging::PENDING,
            "user_id" => Auth::user()->id,
            "box_id" => $boxMessaging->id,
        ]);

        if ($newTicket && $newTicket instanceof TicketMessaging) {
            receiveticket("بهزاد","09331200920");

            flash_message("تیکت با موفقیت ثبت شد !", 'success');
        } else {
            flash_message("مشکلی رخ داده ! بعدا امتحان نمایید !", 'danger');
        }
        return redirect()->route('user.ticket.list');
    }

    public function showContent(Request $request)
    {
        $box_id = $request->id;
        $boxMessaging = BoxMessaging::find($box_id);
        if (!$boxMessaging) {
            exit;
        }
        $allTickets = $boxMessaging->ticketMessagings;
        $html = view("user.ticketMessage.sections.showContentTicket", compact("allTickets", "boxMessaging"))->render();
        return response($html);
    }

    public function getAnswers(Request $request)
    {
        $ticketID = $request->id;
        $tiket = TicketMessaging::find($ticketID);
        if (!$tiket) {
            exit;
        }
        $answers = $tiket->ticketAnswers;
        $html = view("user.ticketMessage.sections.ticketAnswersAjax", compact("answers"))->render();
        return response($html);
    }
}
