@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Order Cancel List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Order ID</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($cancel_order_list as $sl=>$cancel_order)
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>{{App\Models\Order::find($cancel_order->order_id)->order_id}}</td>
                                <td>
                                    <a href="{{route('order.cancel.details',$cancel_order->id)}}" class="btn btn-info text-white">View</a>
                                    <a href="{{route('cancel.accept',$cancel_order->id)}}" class="btn btn-success text-white">Accept</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
