<!DOCTYPE html>
<html lang="en">
<head>
    <title>Trip Sheet</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>

            .divFooter {
                position: fixed;
                bottom: 0;
            }
            .page-break {
                page-break-after: always;
            }

    </style>

</head>
<body>
<?php setlocale(LC_MONETARY, 'en_IN'); ?>
    <div class="page-break">
        <p class="pull-right">Exported From <a href="https://myvehicle.biz"></a>, Developed by <img src="https://greefitech.com/images/logo1.png" alt="Greefi Technologies" style="height: 35px;"> <img src="https://greefitech.com/images/logo.png" alt="Greefi Technologies" style="height: 25px;"></p>
        <table border="1px" style="width: 100%;">
            <tr>
                <td colspan="6" class="text-center"><h3><b>{{ Auth::user()->transportName }} , {{ Auth::user()->address }}</b></h3></td>
            </tr>
            <tr>
                <th>லாரி நெ : {{ $Trip->vehicle->vehicleNumber }}</th>
                <th>அட்வான்ஸ் : {{ money_format('%!i', $Trip->advance) }}</th>
                <th>ட்ரிப் நெ : {{ $Trip->tripName }}</th>
                <th>தேதி : {{ date("d-m-Y", strtotime($Trip->dateFrom)) }}</th>
                <th>To : {{  date("d-m-Y", strtotime($Trip->dateTo)) }}</th>
                <th>நாள் : {{ $days = Carbon\Carbon::parse($Trip->dateFrom)->diffInDays($Trip->dateTo)+1 }}</th>
            </tr>
            <tr>
                <th>ஆரம்ப கி.மீ : {{ $Trip->startKm }}</th>
                <th>முடிவு கி.மீ : {{ $Trip->endKm }}</th>
                <th>ஓடிய கி.மீ : {{ @$Trip->endKm - @$Trip->startKm }}</th>
                <th>டீசல் : {{ $Diesels->sum('quantity') }} (லி)</th>
                <th>மைலேஜ் : {{ ($Diesels->sum('quantity')==0)? 0:round((@$Trip->endKm - @$Trip->startKm)/@$Diesels->sum('quantity'),2) }}</th>
                <?php $ExpenseTotal =  $Diesels->sum('amount') + @$entryDatas->sum('comission') + @$entryDatas->sum('loadingMamool') + @$entryDatas->sum('unLoadingMamool') + $RTO->sum('amount') + @$PC->sum('amount') + @$paalam->sum('amount') + @$Naakka->sum('amount') + @$checkPost->sum('amount') + $otherExpenses->sum('amount') + @$BillPadi->sum('amount')  + @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount') + @$pattarai->sum('amount')  ?>
                <th>நாள் மீதி : {{ @round((Auth::user()->TripTotalIncome($Trip->id) - Auth::user()->TripTotalExpense($Trip->id))/$days, 2) }}</th>
            </tr>
            <tr>
                <th colspan="2">டிரைவர்  1 : {{ @$Trip->Staff1->name }} - {{ @$Trip->Staff1->mobile1 }} ( {{ @$Trip->Staff1->licenceNumber }} - {{ date("d-m-Y", strtotime(@$Trip->Staff1->licenceRenewal)) }} ) </th>
                <th colspan="2">டிரைவர்  2 : {{ (@$Trip->Staff2->name)?$Trip->Staff2->name.' - '.@$Trip->Staff2->mobile1.' ( '.@$Trip->Staff2->licenceNumber.' - '.date("d-m-Y", strtotime(@$Trip->Staff2->licenceRenewal)).' ) ':'Nil' }}</th>
                <th colspan="1">கிளீனர் : {{ (@$Trip->Staff3->name)?$Trip->Staff3->name:'Nil' }} {{ (@$Trip->Staff3->mobile1)?$Trip->Staff3->mobile1:'' }}</th>
                <th colspan="1">கி.மீ மீதி  : {{ @round((Auth::user()->TripTotalIncome($Trip->id) - Auth::user()->TripTotalExpense($Trip->id))/$runningkm, 2) }}</th>
            </tr>
        </table>
        <div style="width: 70%; float: left;">
            <table border="1px" style="width: 100%;">
                <tr>
                    <th colspan="10" style="text-align: center;">Entry Data</th>
                </tr>
                <tr>
                    <th>தேதி</th>
                    <th>புறப்படுமிடம் to சேருமிடம் </th>
                    <th>லோடு</th>
                    <th>டன் </th>
                    <th>வாடகை </th>
                    <th>வரவு </th>
                    <th>கமிசன்</th>
                    <th>ஏற்றுமதிக்கூலி</th>
                    <th>இறக்குக்கூலி </th>
                    <th>லோடு ஏஜெண்சி பெயர்</th>
                </tr>
                <?php $totalIncome =0; ?>
                @foreach($entryDatas as $entryData)
                    <tr>
                        <td>{{  date("d-m-Y", strtotime($entryData->dateFrom)) }}</td>
                        <td>{{ $entryData->locationFrom }} To {{ $entryData->locationTo }}</td>
                        <td>{{ $entryData->loadType }}</td>
                        <td>{{ $entryData->ton }}</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryData->billAmount) }}</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryData->advance) }} </td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryData->comission) }}</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryData->loadingMamool) }}</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryData->unLoadingMamool) }}</td>
                        <td style="text-align: right;">{{ @$entryData->customer->name }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4">Total</th>
                    <th style="text-align: right;">&nbsp;{{ money_format('%!i', $entryDatas->sum('billAmount')) }}</th>
                    <th style="text-align: right;">&nbsp;{{ money_format('%!i', $entryDatas->sum('advance')) }}</th>
                    <th style="text-align: right;">&nbsp;{{ money_format('%!i', $entryDatas->sum('comission')) }}</th>
                    <th style="text-align: right;">&nbsp;{{ money_format('%!i', $entryDatas->sum('loadingMamool')) }}</th>
                    <th style="text-align: right;">&nbsp;{{ money_format('%!i', $entryDatas->sum('unLoadingMamool')) }}</th>
                    <th></th>
                </tr>
            </table>
            <div style="width: 60%; float: left;">
                <table border="1px" width="100%" style="float: left;">
                    <tr>
                        <th colspan="13" style="text-align: center;">டீசல்</th>
                    </tr>
                    <tr>
                        <th colspan="2">தேதி</th>
                        <th colspan="3">லிட்டர்</th>
                        <th colspan="3">விவரம்</th>
                        <th colspan="2">மொத்தம்</th>
                        <th colspan="3">விவரம்</th>
                    </tr>
                    @foreach($Diesels as $Diesel)
                        <tr>
                            <td colspan="2">{{  date("d-m-Y", strtotime($Diesel->date)) }}</td>
                            <td colspan="3">{{ $Diesel->quantity }}</td>
                            <td colspan="3">{{ ($Diesel->account_id==1) ? 'cash':$Diesel->Account->account }}</td>
                            <td colspan="2" style="text-align: right;">{{ money_format('%!i', $Diesel->amount) }} </td>
                            <td colspan="3"> &nbsp; {{ $Diesel->discription }} {{ $Diesel->location }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">மொத்த (லி)</th>
                        <th colspan="3">{{ $Diesels->sum('quantity') }}</th>
                        <th colspan="3">மொத்தம்</th>
                        <th colspan="2" style="text-align: right;">{{ money_format('%!i', $Diesels->sum('amount')) }}</th>
                        <th colspan="3"></th>
                    </tr>
                </table>
                <table border="1px" width="100%">
                    <tr>
                        <th colspan="10" style="text-align: center;">வரவு </th>
                    </tr>
                    <tr>
                        <th colspan="2">தேதி</th>
                        <th colspan="3">வரவு</th>
                        <th colspan="2">விவரம்</th>
                    </tr>
                    @foreach($entryDatas as $entryData)
                        @if($entryData->advance > 0)
                            <tr>
                                <td colspan="2">{{ date("d-m-Y", strtotime($entryData->dateFrom)) }}</td>
                                <td colspan="3">{{ money_format('%!i', $entryData->advance) }}</td>
                                <td colspan="2">{{ $entryData->customer->name }} ({{ ($entryData->account_id==1) ? 'cash':$entryData->Account->account }})</td>
                            </tr>
                        @endif()
                    @endforeach
                    @foreach($Incomes as $Income)
                        <tr>
                            <td colspan="2">{{ date("d-m-Y", strtotime($Income->date)) }}</td>
                            <td colspan="3">{{ money_format('%!i', $Income->recevingAmount) }}</td>
                            <td colspan="2">{{ $Income->customer->name }} - ({{ ($Income->account_id==1) ? 'cash':$Income->Account->account }})</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">மொத்தம்</th>
                        <th colspan="3">{{ money_format('%!i', ($Incomes->sum('recevingAmount') + $entryDatas->sum('advance'))) }}</th>
                        <th colspan="2"></th>
                    </tr>
                </table>
                @if(($total_balance = ($entryDatas->sum('billAmount') - Auth()->user()->TripTotalIncome($Trip->id))) != 0)
                    <table border="1px" width="100%">
                        <tr>
                            <th colspan="2" style="text-align: center;">வரவேண்டியது </th>
                        </tr>
                        <tr>
                            <th>விவரம்</th>
                            <th>வரவு</th>
                        </tr>
                        @foreach($entryDatas as $entryData)
                            @if(($balance = ($entryData->billAmount - Auth()->user()->TotalEntryIncome($entryData->id))) != 0 )
                                <tr>
                                    <td>{{ $entryData->customer->name }}</td>
                                    <td>{{ $balance }}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <th>மொத்தம்</th>
                            <th>{{ @$total_balance }}</th>
                        </tr>
                    </table>
                @endif
                @if(!empty($ExpenseNotPaid))
                    <table border="1px" width="100%" style="float: left;">
                        <tr>
                            <th colspan="3" style="text-align: center;">விட்டு போன தொகை </th>
                        </tr>
                        <tr>
                            <th>இதரசெலவுகள்</th>
                            <th>தொகை</th>
                            <th>விவரம்</th>
                        </tr>
                        @foreach($ExpenseNotPaid as $NotPaid)
                            <tr>
                                <td>{{ $NotPaid->ExpenseType->expenseType }}</td>
                                <td style="text-align: right;">{{ money_format('%!i', $NotPaid->amount) }}</td>
                                <td>{{ $NotPaid->discription }} {{ $NotPaid->location }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>மொத்தம்</th>
                            <th style="text-align: right;">{{ money_format('%!i', $ExpenseNotPaid->sum('amount')) }}</th>
                            <th></th>
                        </tr>
                    </table>
                @endif
                @if(!empty($Halts))
                    <table border="1px" width="100%" style="float: left;">
                        <tr>
                            <th colspan="3" style="text-align: center;">வண்டி நிறுத்தம்</th>
                        </tr>
                        <tr>
                            <th>தேதி</th>
                            <th>இடம்</th>
                            <th>விவரம்</th>
                        </tr>
                        @foreach($Halts as $Halt)
                            <tr>
                                <td>{{ @$Halt->date }}</td>
                                <td>{{ @$Halt->location }}</td>
                                <td>{{ @$Halt->reason }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div style="width: 40%; float: left;">
                <table border="1px" style="width: 100%;">
                    <tr>
                        <th> &nbsp; மொத்தம்</th>
                        <th style="text-align: center">ரூ</th>
                    </tr>
                    <tr>
                        <td> &nbsp; டீசல்</td>
                        <td style="text-align: right;">{{ money_format('%!i', $Diesels->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; கமிசன்</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('comission')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; ஏற்று கூலி </td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('loadingMamool')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; இறக்கு கூலி </td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('unLoadingMamool')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; இதரசெலவுகள்</td>
                        <td style="text-align: right;">{{ money_format('%!i', $otherExpenses->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; RTO செலவு</td>
                        <td style="text-align: right;">{{ money_format('%!i', $RTO->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; PC செலவு</td>
                        <td style="text-align: right;">{{ money_format('%!i', $PC->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; நாக்கா</td>
                        <td style="text-align: right;">{{ money_format('%!i', $Naakka->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; பில் படி</td>
                        <td style="text-align: right;">{{ money_format('%!i', $BillPadi->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; செக்போஸ்ட்</td>
                        <td style="text-align: right;">{{ money_format('%!i', $checkPost->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; பாலம் / டோல்கேட்</td>
                        <td style="text-align: right;">{{ money_format('%!i', $paalam->sum('amount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; டிரைவர் படி </td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('driverPadiAmount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; கிளீனர் படி</td>
                        <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('cleanerPadiAmount')) }}</td>
                    </tr>
                    <tr>
                        <td> &nbsp; பட்டறை செலவு</td>
                        <td style="text-align: right;">{{ money_format('%!i', $pattarai->sum('amount')) }}</td>
                    </tr>

                    <tr>
                        <th>  &nbsp; மொத்த செலவு</th>
                        <th style="text-align: right;">{{ money_format('%!i', @$total_expense = $Diesels->sum('amount') + @$entryDatas->sum('comission') + @$entryDatas->sum('loadingMamool') + @$entryDatas->sum('unLoadingMamool') + $RTO->sum('amount') + @$PC->sum('amount') + @$paalam->sum('amount') + @$Naakka->sum('amount') + @$checkPost->sum('amount') + $otherExpenses->sum('amount') + @$BillPadi->sum('amount') +  @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount') + @$pattarai->sum('amount'))  }}</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align: center">  &nbsp;செலவு</th>
                    </tr>
                    <tr>
                        <th>  &nbsp; மொத்த வாடகை </th>
                        <th style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('billAmount')) }}</th>
                    </tr>
                    <tr>
                        <th>  &nbsp; மொத்த செலவு</th>
                        <th style="text-align: right;">{{ money_format('%!i', @$total_expense = $Diesels->sum('amount') + @$entryDatas->sum('comission') + @$entryDatas->sum('loadingMamool') + @$entryDatas->sum('unLoadingMamool') + $RTO->sum('amount') + @$PC->sum('amount') + @$paalam->sum('amount') + @$Naakka->sum('amount') + @$checkPost->sum('amount') + $otherExpenses->sum('amount') + @$BillPadi->sum('amount') +  @$entryDatas->sum('driverPadiAmount')  + @$entryDatas->sum('cleanerPadiAmount') + @$pattarai->sum('amount'))  }}</th>
                    </tr>
                    <tr>
                        <th>  &nbsp; வண்டி மீதி</th>
                        <th style="text-align: right;">{{ money_format('%!i', ($VehicleRemainingAmount = ($entryDatas->sum('billAmount')-$total_expense))) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align: center">  &nbsp;வரவேண்டிய தொகை </th>
                    </tr>
                    <tr>
                        <?php $total_income = ((isset($Incomes))?$Incomes->sum('recevingAmount'):0) + $entryDatas->sum('advance') ?>
                        <th>  &nbsp; வரவேண்டிய தொகை </th>
                        <th style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('billAmount')-$total_income) }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div style="width: 30%; float: left;">
            <table width="100%"></table>
            <div style="width: 50%; float: right">
                <table border="1px" width="100%" style="border-top-right-radius: 25px;">
                    <tr>
                        <th colspan="3" style="text-align: center;">இதரசெலவுகள் </th>
                    </tr>
                    <tr>
                        <th>இதரசெலவுகள்</th>
                        <th>செலவு தொகை</th>
                        <th>விவரம்</th>
                    </tr>
                    @foreach($otherExpenses as $otherExpense)
                        <tr>
                            <td>{{ $otherExpense->ExpenseType->expenseType }}</td>
                            <td style="text-align: right;" >{{ money_format('%!i', $otherExpense->amount) }}</td>
                            <td>{{ $otherExpense->discription }} {{ $otherExpense->location }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        <th style="text-align: right;" >{{ money_format('%!i', $otherExpenses->sum('amount')) }}</th>
                        <th></th>
                    </tr>
                </table>
            </div>
            <div style="width: 50%; float: right;">

                @if(!$paalam->isEmpty())
                        <table border="1px" width="100%">
                            <tr>
                                <th colspan="2" style="text-align: center;">பாலம்</th>
                            </tr>
                            <tr>
                                <th>விவரம்</th>
                                <th style="text-align: right">செலவு தொகை</th>
                            </tr>
                            @foreach($paalam as $paalamData)
                                <tr>
                                    <td>{{ $paalamData->location }} {{ $paalamData->discription }}</td>
                                    <td style="text-align: right">{{ money_format('%!i', $paalamData->amount) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>மொத்தம்</th>
                                <th style="text-align: right">{{ money_format('%!i', $paalam->sum('amount')) }}</th>
                            </tr>
                        </table>
                    @endif
                @if(!$checkPost->isEmpty())
                    <table border="1px" width="100%">
                        <tr>
                            <th colspan="2" style="text-align: center;">செக்போஸ்ட்</th>
                        </tr>
                        <tr>
                            {{--<th>தேதி</th>--}}
                            <th>விவரம்</th>
                            <th style="text-align: right">செலவு தொகை</th>
                        </tr>
                        @foreach($checkPost as $ckPost)
                            <tr>
                                {{--<td colspan="2">{{  date("d-m-Y", strtotime($ckPost->date)) }}</td>--}}
                                <td>{{ $ckPost->location }} {{ $ckPost->discription }}</td>
                                <td style="text-align: right">{{ money_format('%!i', $ckPost->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>மொத்தம்</th>
                            <th style="text-align: right">{{ money_format('%!i', $checkPost->sum('amount')) }}</th>
                            {{--<th colspan="3"></th>--}}
                        </tr>
                    </table>
                @endif
                @if(!$Naakka->isEmpty())
                    <table border="1px" width="100%">
                        <tr>
                            <th colspan="2" style="text-align: center;">நாக்கா</th>
                        </tr>
                        <tr>
                            {{--<th colspan="2">தேதி</th>--}}
                            <th>விவரம்</th>
                            <th style="text-align: right">செலவு தொகை</th>
                        </tr>
                        @foreach($Naakka as $NaakkaData)
                            <tr>
                                {{-- <td colspan="2">{{  date("d-m-Y", strtotime($NaakkaData->date)) }}</td>--}}
                                <td>{{ $NaakkaData->discription }} {{ $NaakkaData->location }}</td>
                                <td style="text-align: right">{{ money_format('%!i', $NaakkaData->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>மொத்தம்</th>
                            <th style="text-align: right">{{ money_format('%!i', $Naakka->sum('amount')) }}</th>
                            {{--<th colspan="2"></th>--}}
                        </tr>
                    </table>
                @endif
                @if(!$BillPadi->isEmpty())
                    <table border="1px" width="100%">
                        <tr>
                            <th colspan="2" style="text-align: center;">பில் படி</th>
                        </tr>
                        <tr>
                            <th>விவரம்</th>
                            <th style="text-align: right" >செலவு தொகை</th>
                        </tr>
                        @foreach($BillPadi as $Bill)
                            <tr>
                                <td>{{ $Bill->discription }} {{ $Bill->location }}</td>
                                <td style="text-align: right" >{{ money_format('%!i', $Bill->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>மொத்தம்</th>
                            <th style="text-align: right" >{{ money_format('%!i', $BillPadi->sum('amount')) }}</th>
                        </tr>


                    </table>
                @endif
            </div>
        </div>
    </div>


<!-- Page 2 -->
    <div class="page-break">
        <div width="100%">
            <table border="1px" width="50%" style="float: left;">
                <tr>
                    <th colspan="2" style="text-align: center;">PC செலவு </th>
                </tr>
                <tr>
                    <th>விவரம்</th>
                    <th style="text-align: center;">தொகை</th>
                </tr>
                @foreach($PC as $pc)
                    <tr>
                        <td>{{ $pc->discription }} {{ $pc->location }}</td>
                        <td style="text-align: right;">{{ $pc->amount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>மொத்தம்</th>
                    <th style="text-align: right;">{{ $PC->sum('amount') }}</th>
                </tr>
            </table>
            <table border="1px" width="50%" style="float: left;">
                <tr>
                    <th colspan="2" style="text-align: center;">RTO செலவு </th>
                </tr>
                <tr>
                    <th>விவரம்</th>
                    <th style="text-align: center;">தொகை</th>
                </tr>
                @foreach($RTO as $rto)
                    <tr>
                        <td>{{ $rto->discription }} {{  $rto->location }}</td>
                        <td style="text-align: right;">{{ $rto->amount }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>மொத்தம்</th>
                    <th style="text-align: right;">{{ $RTO->sum('amount') }}</th>
                </tr>
            </table>
            <hr>
            <center><h3>டிரைவர் கணக்கு</h3></center>


            <table border="1px" width="50%">
                <tr>
                    <th>வாங்கல்/கொடுத்தால் </th>
                    <th>ரூ</th>
                </tr>
                <tr>
                    <td> &nbsp;பாலம்</td>
                    <td style="text-align: right;">{{ money_format('%!i', $paalamCash->sum('amount')) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;டிரைவர் படி </td>
                    <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('driverPadiAmount')) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;கிளீனர் படி</td>
                    <td style="text-align: right;">{{ money_format('%!i', $entryDatas->sum('cleanerPadiAmount')) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;RTO</td>
                    <td style="text-align: right;">{{ money_format('%!i', $RTO->sum('amount')) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;PC</td>
                    <td style="text-align: right;">{{ money_format('%!i', $PC->sum('amount')) }}</td>
                </tr>
                <?php $ComissionPaid=0;$ComissionNotPaid=0;$LoadingPaid=0;$LoadingNotPaid=0;$UnloadingPaid=0;$UnloadingNotPaid=0; ?>
                @foreach($entryDatas as $entryData)
                    <?php
                        if($entryData->commission_status ==1 || $entryData->commission_status ==''){
                            $ComissionPaid+=$entryData->comission;
                        }else{
                            $ComissionNotPaid+=$entryData->comission;
                        }

                        if($entryData->loading_mamool_status ==1 || $entryData->loading_mamool_status ==''){
                            $LoadingPaid+=$entryData->loadingMamool;
                        }else{
                            $LoadingNotPaid+=$entryData->loadingMamool;
                        }

                        if($entryData->unloading_mamool_status ==1 || $entryData->unloading_mamool_status ==''){
                            $UnloadingPaid+=$entryData->unLoadingMamool;
                        }else{
                            $UnloadingNotPaid+=$entryData->unLoadingMamool;
                        }
                    ?>
                @endforeach

                <tr>
                    <td> &nbsp;கமிசன்</td>
                    <td style="text-align: right;">{{ money_format('%!i', $ComissionPaid) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;ஏற்றுமதிக்கூலி</td>
                    <td style="text-align: right;">{{ money_format('%!i', $LoadingPaid) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;இறக்குக்கூலி</td>
                    <td style="text-align: right;">{{ money_format('%!i', $UnloadingPaid) }}</td>
                </tr>
                <tr>
                    <td> &nbsp;இதரசெலவுகள்</td>
                    <td style="text-align: right;">{{ money_format('%!i', $DriverExpenses->sum('amount')) }}</td>
                </tr>

                <tr>
                    <th>செலவு</th>
                    <th>{{ $TotalDriverExpense = abs($DriverExpenses->sum('amount') + $ComissionPaid + $LoadingPaid + $UnloadingPaid + $paalamCash->sum('amount') + $entryDatas->sum('driverPadiAmount') + $entryDatas->sum('cleanerPadiAmount') +$RTO->sum('amount') + $PC->sum('amount')) }}</th>
                </tr>





                <tr><th colspan="2" style="text-align: center;">டிரைவர் செலவு</th></tr>

                <tr>
                    <td>&nbsp; அட்வான்ஸ்</td>
                    <td  style="text-align: right;">{{ $Trip->advance }}</td>

                @foreach($TripAdvanceAmounts as $TripAdvanceAmount)
                    <tr>
                        <td> &nbsp;அட்வான்ஸ் {{ date("d-m-Y", strtotime($TripAdvanceAmount->date)) }} - {{ ($TripAdvanceAmount->account_id ==1)?'Cash':$TripAdvanceAmount->Account->account }}</td>
                        <td style="text-align: right;">{{ money_format('%!i', $TripAdvanceAmount->amount) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td> &nbsp;Entry Cash Advance</td>
                    <td style="text-align: right;">{{ money_format('%!i', $EntryCashAdvance->sum('advance')) }}</td>
                </tr>

                <tr>
                    <td>&nbsp; டிரைவர் செலவு</td>
                    <td style="text-align: right;">{{ money_format('%!i', $TotalDriverExpense) }}</td>
                </tr>

                <tr>
                    <th>&nbsp; மீதி</th>
                    <th>{{ money_format('%!i', (($Trip->advance + $TripAdvanceAmounts->sum('amount') + $EntryCashAdvance->sum('advance')) - $TotalDriverExpense)) }}</th>
                </tr>





            </table>
        </div>
        <p class="pull-right">Exported From <a href="https://myvehicle.biz"></a>, Developed by <img src="https://greefitech.com/images/logo1.png" alt="Greefi Technologies" style="height: 35px;"> <img src="https://greefitech.com/images/logo.png" alt="Greefi Technologies" style="height: 25px;"></p>
    </div>
</body>
</html>




