@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Order List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Order Id</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $sl=>$order)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$order->order_id}}</td>
                            <td>{{$order->total}}</td>
                            <td>{{$order->created_at->diffForHumans()}}</td>
                            <td>
                                @if ($order->status == 0)
                                <span class="badge bg-secondary">Placed</span>
                                @elseif ($order->status == 1)
                                <span class="badge bg-primary">Proccessing</span>
                                @elseif ($order->status == 2)
                                <span class="badge bg-warning">Shipping</span>
                                @elseif ($order->status == 3)
                                <span class="badge bg-info">Ready For Deliver</span>
                                @elseif ($order->status == 4)
                                <span class="badge bg-success">Delivered</span>
                                @elseif ($order->status == 5)
                                <span class="badge bg-danger">Cancel</span>
                                @endif
                            <td>
                                <form action="{{route('status',$order->id)}}" method="POST">
                                    @csrf
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                            Change Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            <button name="status" value="0" class="dropdown-item bg-{{$order->status == 0?'info':''}}">Placed</button>
                                            <button name="status" value="1" class="dropdown-item bg-{{$order->status == 1?'info':''}}">Proccessing</button>
                                            <button name="status" value="2" class="dropdown-item bg-{{$order->status == 2?'info':''}}">Shipping</button>
                                            <button name="status" value="3" class="dropdown-item bg-{{$order->status == 3?'info':''}}">Ready To Deliver</button>
                                            <button name="status" value="4" class="dropdown-item bg-{{$order->status == 4?'info':''}}">Delivered</button>
                                            <button name="status" value="5" class="dropdown-item bg-{{$order->status == 5?'info':''}}">Cancel</button>
                                        </ul>
                                        </div>
                                </form>
                            </td>
                          </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
