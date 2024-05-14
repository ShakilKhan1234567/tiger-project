@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Subscribe List</h3>
                </div>
                <div class="card-body">
                    @if (session('success_delete'))
                        <div class="alert alert-success">{{session('success_delete')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subscribes as $sl=>$subscribe)
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>{{$subscribe->email}}</td>
                                <td>
                                    <a href="{{route('delete.subscribe',$subscribe->id)}}" class="btn btn-danger btn-icon"><i data-feather="trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
