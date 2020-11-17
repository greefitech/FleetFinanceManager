@extends('client.layout.master')

@section('AuditorMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Report {{  date("d-m-Y", strtotime($date_from)) }} - {{  date("d-m-Y", strtotime($date_to)) }}</center>
                    </h4>
                </div>
                <div class="box-body">
                    <center><h5 style="color: red;">Expense Report</h5></center>
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Cash</th>
                                    @foreach($Accounts as $Account)
                                        <th>{{ $Account->account }} - {{ $Account->HolderName }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Loading & Unloading</td>
                                    <td>{{ $EntryData->sum('loadingMamool') + $EntryData->sum('unLoadingMamool') }}</td>
                                    @foreach($Accounts as $Account)
                                        <td></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Commission</td>
                                    <td>{{ $EntryData->sum('driverPadi') + $EntryData->sum('cleanerPadi') }}</td>
                                    @foreach($Accounts as $Account)
                                        <td></td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Driver & Cleaner</td>
                                    <td>{{ $EntryData->sum('comission') }}</td>
                                    @foreach($Accounts as $Account)
                                        <td></td>
                                    @endforeach
                                </tr>
                                @foreach($AuditorExpenseCategories as $AuditorExpenseCategory)
                                    <tr>
                                        <td>{{ $AuditorExpenseCategory->category }}</td>
                                        <td>{{ @$expense[$AuditorExpenseCategory->category]['amount'][1] }}</td>
                                        @foreach($Accounts as $Account)
                                            <td>{{ @$expense[$AuditorExpenseCategory->category]['amount'][$Account->id] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    <center><h5 style="color: green;">Income Report</h5></center>
                    <div class="table-responsive">
                        <table  class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Cash</th>
                                    @foreach($Accounts as $Account)
                                        <th>{{ $Account->account }} - {{ $Account->HolderName }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fright Charges</td>
                                    <td>{{ @$fright_charge[1] }}</td>
                                    @foreach($Accounts as $Account)
                                        <td>{{ @$fright_charge[$Account->id] }}</td>
                                    @endforeach
                                </tr>
                                @foreach($AuditorIncomeCategories as $AuditorIncomeCategory)
                                    <tr>
                                        <td>{{ $AuditorIncomeCategory->category }}</td>
                                        <td>{{ @$IncomeAmount[$AuditorIncomeCategory->category]['amount'][1] }}</td>
                                        @foreach($Accounts as $Account)
                                            <td>{{ @$IncomeAmount[$AuditorIncomeCategory->category]['amount'][$Account->id] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
