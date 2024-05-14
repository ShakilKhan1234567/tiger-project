@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit SubCategory</h3>
            </div>
            <div class="card-body">
                @if (session('sub_cat'))
                    <div class="alert alert-success">{{session('sub_cat')}}</div>
                @endif
                @if (session('sub_update'))
                    <div class="alert alert-success">{{session('sub_update')}}</div>
                @endif
              <form action="{{route('update.subcategory',$subcategories->id)}}" method="POST">
                @csrf
                <div class="mt-2">
                    <select name="select_category" class="form-control">
                        <option value="">Select Category</option>
                         @foreach ($categories as $category)
                         <option {{$subcategories->category_id == $category->id?'selected':''}} value="{{$category->id}}">{{$category->category_name}}</option>
                         @endforeach
                    </select>
                    @error('select_category')
                    <div class="alert alert-danger mt-2">{{$message}}</div>
                @enderror
                </div>
                <div class="mt-2">
                    <label class="form-label">Subcategory name</label>
                    <input type="text" name="subcategory_name" class="form-control" value="{{$subcategories->subcategory_name}}">
                    @error('subcategory_name')
                        <div class="alert alert-danger mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
