@extends('layouts.admin')
@section("content")
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Banner List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                        <th>SL</th>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Action</th>
                        </tr>
                        @foreach ($banners as $sl=>$banner)
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>
                                    <img width="150" src="{{asset('uploads/banner')}}/{{$banner->photo}}" alt="">
                                </td>
                                <td>{{$banner->title}}</td>
                                <td>
                                    <a href="{{route('banner.edit',$banner->id)}}" class="btn btn-primary btn-icon"><i data-feather="edit"></i></a>
                                    <a href="{{route('banner.delete',$banner->id)}}" class="btn btn-danger btn-icon"><i data-feather="trash"></i></a>
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
                    <h3>Add Banner</h3>
                </div>
                <div class="card-body">
                    @if (session('banner_success'))
                    <div class="alert alert-success">{{session('banner_success')}}</div>
                    @endif
                    <form action="{{route('banner.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                        @error('title')
                            <div class="alert alert-success mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" class="form-control" name="photo">
                        @error('photo')
                            <div class="alert alert-success mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Button</label>
                        <select name="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
