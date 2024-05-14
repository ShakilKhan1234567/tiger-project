@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
                    @if (session('delete'))
                        <div class="alert alert-success">{{session('delete')}}</div>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Coupon</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Validity</th>
                            <th>Limit</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($coupons as $sl=>$coupon )
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$coupon->coupon}}</td>
                            <td>{{$coupon->type}}</td>
                            <td>{{$coupon->amount}}</td>
                            <td>{{$coupon->validity}}</td>
                            <td>{{$coupon->limit}}</td>
                            <td>
                         <a href="{{route('coupon.status',$coupon->id)}}" class="btn btn-{{$coupon->status == 1?'success':'info'}}">{{$coupon->status == 1?'Active':'Deactive'}}</a>
                           </td>
                            <td>
                                <a href="{{route('delete.status',$coupon->id)}}" type="button" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Ad New Coupon</h3>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">{{session('success')}}</div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{route('coupon.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Coupon</label>
                            <input type="text" name="coupon" class="form-control">
                            @error('coupon')
                                <div class="alert alert-danger mt-2">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">type</label>
                            <select name="type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="1">Percentage</option>
                                <option value="2">Solid</option>
                            </select>
                            @error('type')
                                <div class="alert alert-danger mt-2">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control">
                            @error('amount')
                                <div class="alert alert-danger mt-2">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Validity</label>
                            <input type="date" name="validity" class="form-control">
                            @error('validity')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit</label>
                            <input type="number" name="limit" class="form-control">
                            @error('limit')
                                <div class="alert alert-danger mt-2">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Add Coupon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
