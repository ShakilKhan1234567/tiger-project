@extends('frontend.master')
@section('content')
    <!-- start wpo-page-title -->
    @include('frontend.breadcrums')
    <!-- end page-title -->

    <div class="container">
        <div class="row mt-2">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header">OrderID :{{session('success')}}</div>
                    <div class="card-body">
                        <img src="{{asset('uploads/order.png')}}" alt="success">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
