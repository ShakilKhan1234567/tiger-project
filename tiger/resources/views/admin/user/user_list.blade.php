@extends('layouts.admin')
@section('content')
@can('user_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2>User List</h2>
            </div>
            <div class="card-body">
                @if (session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <table class="table table-bordered">
                <tr>
                    <th>SL</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $key=>$user)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        @if ($user->photo == null)
                        <img src="{{ Avatar::create($user->name)->toBase64() }}"/>
                        @else
                        <img src="{{asset('uploads/user')}}/{{$user->photo}}"/>
                        @endif
                    </td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @can('user_delete')
                    <td>
                        <a href="{{route('delete.user', $user->id)}}" type="button" class="btn btn-danger btn-icon">
                            <i data-feather="trash"></i>
                        </a>
                    </td>
                    @endcan
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
    @can('user_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>User Add</h3>
            </div>
            <div class="card-body">
                @if (session('add'))
                    <div class="alert alert-success">{{session('add')}}</div>
                @endif
                <form action="{{route('user.add')}}" method="post">
                @csrf
                <div class="my-2">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    @error('name')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-2">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{old('email')}}">
                    @error('email')
                    <div class="alert alert-success mt-2">{{$message}}</div>
                @enderror
                </div>
                <div class="my-2">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" value="{{old('password')}}">
                    @error('password')
                    <div class="alert alert-success mt-2">{{$message}}</div>
                @enderror
                </div>
                <div class="my-2">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" value="{{old('confirm_password')}}">
                    @if (session('match'))
                    <div class="alert alert-success mt-2">{{session('match')}}</div>
                    @endif
                    @error('confirm_password')
                    <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-2">
                   <button type="submit" class="btn btn-primary">User Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endcan
@endsection
