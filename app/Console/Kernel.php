<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //

        'App\Console\Commands\DeleteExpired',
        'App\Console\Commands\autoDeleteAd',
        'App\Console\Commands\UpdateStatistic',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();



        //  $schedule->command('statistic:update')
        //  ->everyMinute();
         //->hourlyAt(15);
        
          
//   $schedule->command('queue:retry')
//       ->everyMinute();
            


        $schedule->command('queue:work')
       ->everyMinute();
       
  
       
        //   $schedule->command('queue:restart')
        //     ->everyMinute();
        
            
        //   $schedule->command('cache:clear')
        //     ->everyMinute();
           
            
        $schedule->command('expired:delete')
            ->dailyAt('19:13');
            
            
                        
        $schedule->command('ad:delete')
          ->hourlyAt(30);
            //->everyMinute();



    
            
            

        //  $schedule->command('expired:delete')
        // ->everyMinute();

        //      $schedule->command('expired:delete')
        // ->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
