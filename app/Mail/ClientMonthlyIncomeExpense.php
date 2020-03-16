<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientMonthlyIncomeExpense extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.clientMonthlyIncomeExpense')->subject("Monthly Profit Expense ".$this->details['transportName'].' - '.date("F", mktime(0, 0, 0, config('mohan.income_expense_send_mail_month'),10)).' - '.config('mohan.income_expense_send_mail_year'));
    }
}
