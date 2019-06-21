@extends('manager.layout.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Edit RTO Master</center>
                    </h4>
                    <a href="{{ route('manager.ViewRTOMasters') }}" class="btn btn-info pull-right">View RTO Master</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="{{ route('manager.UpdateRTOMaster',$RTOMasters->id) }}">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('place') ? ' has-error' : '' }}">
                                        <div class="col-sm-12">
                                            <label>Master Place</label>
                                            <input type="text" class="form-control" min="0" value="{{ $RTOMasters->place }}" placeholder="Enter place" name="place">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Master Expense
                                                <button type="button" class="btn btn-primary btn-sm pull-right AddRTOMasterInput"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="panel-body">
                                                <table  class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Place</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="RTOMasterTableData">
                                                        @if(!empty(unserialize($RTOMasters->description)))
                                                            <?php $RTOMasterDatas = unserialize($RTOMasters->description) ?>
                                                            @foreach($RTOMasterDatas['location'] as $RTOKey=>$RTO)
                                                            <tr>
                                                                <td class="{{ $errors->has('RTOData.location.'.$RTOKey) ? ' has-error' : '' }}">
                                                                    <input type="text" class="form-control" name="RTOData[location][]" value="{{ $RTOMasterDatas['location'][$RTOKey] }}">
                                                                </td>
                                                                <td class="{{ $errors->has('RTOData.amount.'.$RTOKey) ? ' has-error' : '' }}">
                                                                    <input type="number" min="0" class="form-control" name="RTOData[amount][]" value="{{ $RTOMasterDatas['amount'][$RTOKey] }}">
                                                                </td>
                                                                <td><i style="color: red;" class="fa fa-close RemoveRTOMasterInput"></i></td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div align="center">
                                <button type="submit" class="btn btn-info">Update RTO Master</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <style>
        td input[type="text"], td select, td input[type="number"] {
            width:40em;
        }
    </style>

    <script>
        $('tbody').sortable();
    </script>
    <script src="{{ url('/js/rtomaster.js') }}"></script>

@endsection