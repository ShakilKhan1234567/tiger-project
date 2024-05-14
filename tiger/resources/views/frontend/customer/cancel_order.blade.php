@extends('frontend.master')

@section('content')
    <div class="col-lg-8 m-auto mt-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Order Cancel Request</h3>
                <h3 class="bg-info d-inline-block p-2">{{$order_info->order_id}}</h3>
            </div>
            @if (session('cancel_order'))
                    <div class="alert alert-success mt-2">{{session('cancel_order')}}</div>
                @endif

            <div class="card-body">
                <form action="{{route('cancel.order.req',$order_info->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Cancel Reason</label>
                    <textarea name="reason" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="photo" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
