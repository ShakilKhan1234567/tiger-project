@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Profile Update Info</h6>
                @if (session('update_info'))
                    <div class="alert alert-success">{{session('update_info')}}</div>
                @endif
                <form class="forms-sample" action="{{route('profile_update_info')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                 </form>
              </div>
          </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Password Update</h6>
                @if (session('pass_update'))
                <div class="alert alert-danger mt-2">{{session('pass_update')}}</div>
               @endif
                <form class="forms-sample" action="{{route('password_update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Current Password</label>
                        <input type="password" class="form-control" name="current_password">
                        @error('current_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                       @if (session('invalid_password'))
                           <div class="alert alert-danger mt-2">{{session('invalid_password')}}</div>
                       @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">New Password</label>
                        <input type="password" class="form-control" name="password">
                        @error('password')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation">
                        @error('password_confirmation')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                 </form>
              </div>
          </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Photo Update</h6>
                <form class="forms-sample" action="{{route('photo_update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        @if (session('photo_update'))
                            <div class="alert alert-success">{{session('photo_update')}}</div>
                        @endif
                        <input type="file" class="form-control" name="photo"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" width="150" src="{{asset('uploads/user')}}/{{Auth::user()->photo}}" alt="">
                        @error('photo')
                            <div class="alert alert-success">{{$message}}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                 </form>
              </div>
          </div>
    </div>
</div>
@endsection
