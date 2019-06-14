@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>{{ $Vehicle->vehicleNumber }} Vehicle Document</center>
                    </h4>
                    <a href="{{ route('client.AddDocument',$Vehicle->id) }}" class="btn btn-info pull-right">Add Document</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Vehicle->DocumentsList($Vehicle->id)->isEmpty())
                            <table  class="table table-bordered table-striped DataTable table-hover">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>Due Date</th>
                                        <th>Interval</th>
                                        <th>Due Days</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($Vehicle->DocumentsList($Vehicle->id) as $Document)
                                    <tr>
                                        <td>{{ $Document->DocumentType->documentType }}</td>
                                        <td>{{ date("d-m-Y", strtotime($Document->duedate)) }}</td>
                                        <td>{{ $Document->interval }}</td>
                                        <td><span style="color: {{ (DateDifference($Document->duedate)<=$Document->notifyBefore)?'red':'green' }};font-weight: bold;">{{ DateDifference($Document->duedate) }}</span></td>
                                        <td>{{ $Document->amount }}</td>
                                        <td>
                                            <form action="{{ route('client.DeleteDocument',$Document->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('client.EditDocument',$Document->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                <button onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Document till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection