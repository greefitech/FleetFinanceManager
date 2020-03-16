<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\ClientMonthlyIncomeExpense as ClientMonthlyIncomeExpenseMail;
use Mail;

class SendClientMonthlyIncomeExpense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ClientMonthlyIncomeExpenseMail($this->details);
        // Mail::to($this->details['email'])->cc(config('mohan.mail_income_expense_cc'))->bcc(config('mohan.mail_income_expense_bcc'))->send($email);
        Mail::to($this->details['email'])->send($email);
    }
}
