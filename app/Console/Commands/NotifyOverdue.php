<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rent;

class NotifyOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rent:notify-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rentOverdue=Rent::where('status', true)->where('date_due', '<', Carbon::now())->get();
        //foreach($rentOverdue)
        //notify_>rentoverdue(data/rent)
    }
}
