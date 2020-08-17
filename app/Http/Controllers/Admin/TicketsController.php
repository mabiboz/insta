<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoxMessaging;
use App\Models\TicketAnswer;
use App\Models\TicketMessaging;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index()
    {
        $boxMessages = BoxMessaging::latest()->paginate(50);
        return view("admin.tickets.all", compact("boxMessages"));
    }

    public function detailAndShowFormAnswer(Request $request)
    {
        $box_id = $request->id;
        $boxMessaging = BoxMessaging::find($box_id);
        if (!$boxMessaging) {
            exit;
        }
        $html = view("admin.tickets.sections.ajaxDetailAndFormAnswer", compact("boxMessaging"))->render();
        return response($html);
    }

    public function close(BoxMessaging $boxMessaging)
    {
        $result = $boxMessaging->update([
            "status" => BoxMessaging::CLOSED,
        ]);
        if($result){
            flash_message("تیکت با موفقیت بسته شد !","success");
        }else{
            flash_message("مشکلی در عملیات رخ داده !","danger");
        }
        return back();
    }

    public function registerAnswer(TicketMessaging $ticket, Request $request)
    {
        $this->validate($request, [
            'answerContent' => 'required',
        ], [
            'answerContent.required' => 'محتوا پاسخ تیکت الزامی می باشد !',
        ]);
        $newAnswer = TicketAnswer::create([
            "content" => $request->answerContent,
            "user_id" => Auth::user()->id,
            "ticket_id" => $ticket->id,
        ]);
        if ($newAnswer) {
            $ticket->update([
                "status" => TicketMessaging::ANSWERED,
            ]);

            answerticket($ticket->user->name, $ticket->user->mobile);

            flash_message("پاسخ با موفقیت ثبت شد !", "success");
        } else {
            flash_message("متاسفانه مشکلی رخ داده ! دوباره تلاش نمایید .", "danger");
        }
        return back();
    }
}
