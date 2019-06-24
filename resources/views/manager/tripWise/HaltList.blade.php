@extends('manager.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Halt List</center>
                    </h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!$Halts->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Reason</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Halts as $Halt)
                                        <tr>
                                            <td>{{ date("d-m-Y", strtotime($Halt->date)) }}</td>
                                            <td>{{ $Halt->location }}</td>
                                            <td>{{ $Halt->reason }}</td>
                                            <td>{{ (!empty($Halt->manager))?$Halt->manager->name:auth()->user()->name }}</td>
                                            <td>
                                                <form action="{{ route('manager.DeleteHalt',$Halt->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('manager.EditHalt',$Halt->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
                                                    <button onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Halt till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection