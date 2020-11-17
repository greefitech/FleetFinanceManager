@extends('client.layout.master')

@section('AuditorMenu','active')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Category</center>
                    </h4>
                </div>
                <div class="box-body">
                    @if(isset($AuditorExpenseCategory))
                        {!! Form::model($AuditorExpenseCategory,['url' => action('ClientController\Auditor\ExpenseCategoryGroupController@update',$AuditorExpenseCategory->id),'method' => 'PUT','class'=>'form-horizontal']) !!}
                        @else
                        {!! Form::open(['url' => action('ClientController\Auditor\ExpenseCategoryGroupController@store'),'method' => 'post','class'=>'form-horizontal']) !!}
                    @endif

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        {!! Form::label('category','Category') !!}
                                        {!! Form::text('category',null,['class'=>'form-control','placeholder'=>'Category Name']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        {!! Form::label('type','Type') !!}
                                        {!! Form::select('type',['expense'=>'Expense','income'=>'Income'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('expense_type_id') ? ' has-error' : '' }}">
                                    <div class="col-sm-12">
                                        {!! Form::label('expense_type_id','Expense Type') !!}
                                        @if(isset($AuditorExpenseCategory))
                                            {!! Form::select('expense_type_id[]',$ExpenseTypes->pluck('expenseType','id'),$AuditorExpenseTypes->pluck('expense_type_id'),['class'=>'form-control','multiple']) !!}
                                        @else
                                            {!! Form::select('expense_type_id[]',$ExpenseTypes->pluck('expenseType','id'),null,['class'=>'form-control','multiple']) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div align="center">
                            <button type="submit" class="btn btn-info">Save Expense Category</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


@endsection
