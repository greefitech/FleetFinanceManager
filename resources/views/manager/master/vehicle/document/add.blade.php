@extends('manager.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Add {{ $Vehicle->vehicleNumber }} Document</center>
                    </h4>
                    <a href="{{ route('manager.ViewDocuments',$Vehicle->id) }}" class="btn btn-info pull-right">View Documents</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('manager.SaveDocument',$Vehicle->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('documentType') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Document Type</label>
                                            <select class="form-control" name="documentType">
                                                <option value="">Select Document Type</option>
                                                @foreach($DocumentTypes as $DocumentType)
                                                    <option value="{{ $DocumentType->id }}" {{ (old('documentType') ==$DocumentType->id )?'selected':'' }}>{{ $DocumentType->documentType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('duedate') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Due Date</label>
                                            <input type="date" class="form-control" value="{{ old('duedate') }}" placeholder="Enter Due Date" name="duedate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('notifyBefore') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Notify Before(Days)</label>
                                            <input type="number" class="form-control" min="1" value="{{ old('notifyBefore') }}" placeholder="Enter Notify Before" name="notifyBefore">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('interval') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Interval(Months)</label>
                                            <input type="number" class="form-control" min="0" value="{{ old('interval') }}" placeholder="Enter Intervel" name="interval">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('issuingCompany') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Issuing Company</label>
                                            <input type="text" class="form-control" value="{{ old('issuingCompany') }}" placeholder="Enter Issuing Company" name="issuingCompany">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Amount</label>
                                            <input type="number" class="form-control" value="{{ old('amount') }}" placeholder="Enter Amount" name="amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Add Document</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection