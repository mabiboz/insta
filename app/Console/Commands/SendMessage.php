<?php

namespace App\Console\Commands;

use App\Appointment;
use Illuminate\Console\Command;

class SendMessage extends Command
{
	protected $signature = 'appointment:sendMessage';

	protected $name = 'appointment:sendMessage';


	protected $description = "this is send message appoint if it is time";

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$appoints = Appointment::all()->where('state', '=', 'تایید شد');
		if (count($appoints))
		{
			// نوبت هایی با شرایط تایید شده یافت شد
			foreach ($appoints as $appoint) {
				// دریافت اطلاعات تاریخ نوبت تایید شده
				$appoint_array = explode('-', $appoint->meeting->rooz);
				$appoint_gdate = \Morilog\Jalali\jDateTime::toGregorian(
					$appoint_array[0], $appoint_array[1], $appoint_array[2]
				);

				// تحلیل تعداد روزهای مانده به نوبت
				$state = \Carbon\Carbon::createFromDate($appoint_gdate[0], $appoint_gdate[1], $appoint_gdate[2])->diffForHumans();

				// بررسی شرایطی که من لازم دارم: ۱ روز قبل نوبت
				if ($state == "1 days ago") {

					// شرایط یک روز قبل نوبت فراهم است
					// کد های ارسال پیامک در اینجا قرار بگیره

					// ******************* ارسال پیامک   **************** //



					// *************** اتمام ارسال پیامک *****************//
				}

			}
		}
		else
		{
			// نوبتی با عنوان تایید شد وجود ندارد همه ی نوبت ها یا رزرون یا رد شده
			return;
		}

	}
}
