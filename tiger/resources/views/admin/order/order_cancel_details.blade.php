@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Order Cancel Details</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <td>ID:</td>
                                <td>{{App\Models\Order::find($cancel_details->order_id)->order_id}}</td>
                            </tr>
                            <tr>
                                <td>Reason</td>
                                <td>{{$cancel_details->reason}}</td>
                            </tr>
                            <tr>
                                <td>Image:</td>
                                <td>
                                    <img width="300" src="{{asset('uploads/cancelorder')}}/{{$cancel_details->photo}}" alt="">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
