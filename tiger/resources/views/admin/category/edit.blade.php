@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-4 m-auto">
        <div class="card">
            <div class="card-header">
                <h4>Edit Category </h4>
            </div>
            <div class="card-body">
                @if (session('update'))
                <div class="alert alert-success">{{session('update')}}</div>
                @endif
                @if (session('category_add'))
                <div class="alert alert-success">{{session('category_add')}}</div>
               @endif
                <form action="{{route('update.category',$cat_id->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="my-2">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-control" name="category_name" value="{{$cat_id->category_name}}">
                    @error('category_name')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-2">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" name="icon"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    <img id="blah" width="150" src="{{asset('uploads/category')}}/{{$cat_id->icon}}" alt="">
                    @error('icon')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
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
