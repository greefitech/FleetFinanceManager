<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Client;
use App\Jobs\SendClientMonthlyIncomeExpense;

class ClientMonthlyIncomeExpenseJobQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*Dont remove this code its for development checking for single client by mohan*/
        if(env('APP_ENV') =='localmohan'){
            $client = Client::findorfail(3);
            SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
        }

        if(env('APP_ENV') =='production'){
            $clients = Client::where('mail_notification',1)->get();
            foreach ($clients as $key => $client) {
                SendClientMonthlyIncomeExpense::dispatch($client)->delay(now()->addSecond(10));
            }
        }
    }
}
