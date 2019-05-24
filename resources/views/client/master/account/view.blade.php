@extends('client.layout.master')

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h4>
                        <center>Accounts</center>
                    </h4>
                    <a href="{{ route('client.AddAccount') }}" class="btn btn-info pull-right">Add Account</a>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        @if(!auth()->user()->Accounts->isEmpty())
                            <table  class="table table-bordered table-striped DataTable">
                                <thead>
                                    <tr>
                                        <th>Account / Bank Name</th>
                                        <th>Holder Name</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->Accounts as $Account)
                                        <tr>
                                            <td>{{ $Account->account }}</td>
                                            <td>{{ $Account->HolderName }}</td>
                                            <td>{{ (!empty($Account->manager))?$Account->manager->name:auth()->user()->name }}</td>
                                            <td>
                                                <form action="{{ route('client.DeleteAccount',$Account->id) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('client.EditAccount',$Account->id) }}" class="btn"><i class="fa fa-pencil text-aqua"></i></a>
{{--                                                    <button href="" onclick="return confirm('Are you sure?')" class="btn"><i class="fa fa-trash-o"></i></button>--}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <blockquote><p>No Vehicle till now added!!</p></blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection