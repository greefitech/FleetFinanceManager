<?php

namespace App\Http\Controllers\ClientController\vendorPayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;
use App\VendorExpensePayment;

class VendorPaymentListController extends Controller
{

    public function __construct(){
        $this->VendorExpensePayment = new VendorExpensePayment();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $VendorExpensePayments = $this->VendorExpensePayment::where('clientid',auth()->user()->id)->with('expense')->latest();
            return DataTables::of($VendorExpensePayments)
            ->addColumn('action',function($VendorExpensePayment){
                return '
                    <a href="'.action('ClientController\vendorPayment\VendorPaymentListController@destroy',$VendorExpensePayment->id).'" class="btn btn-md Delete" data-toggle="tooltip" data-placement="right" DeleteMessage="Delete Vendor Expense Payment" style="color:red"><i class="fa fa-trash"></i></a>';
            })
            ->addColumn('vehicle',function($VendorExpensePayment){
                return $VendorExpensePayment->expense->vehicles->vehicleNumber;
            })
            ->addColumn('vendor_id',function($VendorExpensePayment){
                return $VendorExpensePayment->vendor->name;
            })
            ->editColumn('date',function($VendorExpensePayment){
                return  date("d-m-Y", strtotime($VendorExpensePayment->date));
            })

            ->editColumn('expense_id',function($VendorExpensePayment){
                return $VendorExpensePayment->expense->ExpenseTypes->expenseType;
            })
            ->rawColumns(['action'])->make(true);
        }
        return view('client.trip.vendor_payment.VendorPaidList');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id){
         try {
            $this->VendorExpensePayment::findorfail($id)->delete();
            return ['status' => 'success','msg' => 'Vendor Expense Payment Deleted Successfully'];
        }catch (Exception $e){
            return ['status' => 'error','msg' => 'Vendor Expense Payment not Deleted'];
        }
    }
}
