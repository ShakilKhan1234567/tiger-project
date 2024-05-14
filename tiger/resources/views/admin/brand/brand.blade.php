@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
       <div class="card">
        <div class="card-header">
            <h3>Brand List</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            <table class="table table-bordered">
               <tr>
                <th>SL</th>
                <th>Brand Name</th>
                <th>Brand Logo</th>
                <th>Action</th>
               </tr>
               @foreach ($brands as $key=>$brand)
               <tr>
                <td>{{$key+1}}</td>
                <td>{{$brand->brand_name}}</td>
                <td>
                    <img src="{{asset('uploads/brand')}}/{{$brand->brand_logo}}" alt="">
                </td>
                <td>
                    <a href="{{route('delete.brand',$brand->id)}}" type="button" class="btn btn-danger btn-icon">
                        <i data-feather="trash"></i>
                    </a>
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
                <h3>Add New Brand</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <form action="{{route('brand')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label class="form-label">Brand name</label>
                        <input type="text" name="brand_name" class="form-control">
                        @error('brand_name')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Brand Logo</label>
                        <input type="file" name="brand_logo" class="form-control">
                        @error('brand_logo')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
