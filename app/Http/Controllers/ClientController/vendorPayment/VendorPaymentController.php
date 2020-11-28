<?php

namespace App\Http\Controllers\ClientController\vendorPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendor;
use App\Expense;
use App\VendorExpensePayment;

class VendorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.trip.vendor_payment.VendorList');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'date'=>'required|date|after:'.date('2010-01-01'),
            'account_id'=>'required',
            'expense'=>'required',
        ]);
        try {
            foreach (request('expense') as $expense_id => $amount) {
                if (!empty($amount)) {
                    $VendorExpensePayment = new VendorExpensePayment();
                    $VendorExpensePayment->date = request('date');
                    $VendorExpensePayment->vendor_id = request('vendor_id');
                    $VendorExpensePayment->expense_id = $expense_id;
                    $VendorExpensePayment->amount = $amount;
                    $VendorExpensePayment->clientid  = auth()->user()->id;
                    $VendorExpensePayment->save();
                }
            }
            return back()->with('success',['Vendor Payment','Added Successfully!']);
        }catch (Exception $e){
            return back()->with('danger','Something went wrong!');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Data['vendor'] = Vendor::findorfail($id);

        $Expenses = Expense::where([['clientid', auth()->user()->id],['vendor_id', $id],['status',0]])->get();
        $VendorExpensePayment = VendorExpensePayment::where([['clientid', auth()->user()->id],['vendor_id', $id]])->groupby('expense_id')->selectRaw('expense_id,sum(amount) as amount')->get()->pluck('amount','expense_id')->toArray();
        $ExpenseDataFinal=array();
        foreach ($Expenses as $key => $Expense) {
            $amount = $Expense['amount'] - @$VendorExpensePayment[$Expense->id];
            if($amount != 0){
                $ExpenseData = $Expense;
                $ExpenseData['amount'] = $amount;
                $ExpenseDataFinal[] = $ExpenseData;
            }
        }
        $Data['FinalExpenseDatas'] = $ExpenseDataFinal;
        return view('client.trip.vendor_payment.payment',$Data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
