@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-5 m-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4>Edit Category </h4>
                <a href="{{route('banner')}}" class="btn btn-primary p-1"><i data-feather="list"></i>Back To Banner</a>
            </div>
            <div class="card-body">
                @if (session('update'))
                    <div class="alert alert-success">{{session('update')}}</div>
                @endif
                <form action="{{route('update.banner',$banners->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="my-2">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="{{$banners->title}}">
                </div>
                <div class="my-2">
                    <label class="form-label">Photo</label>
                    <input type="file" class="form-control" name="photo"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    <img id="blah" width="100" src="{{asset('uploads/banner')}}/{{$banners->photo}}" alt="">
                </div>
                <div class="my-2">
                   <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
