@extends('layouts.admin')
@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card mt-5">
            <div class="card-header">
                <h3>Add New Role</h3>
            </div>
            @if (session('update_role'))
                <div class="alert alert-success mt-2">{{session('update_role')}}</div>
            @endif
            <div class="card-body">
                <form action="{{route('update.role',$role->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Role Name</label>
                        <input type="text" name="role_name" class="form-control" value="{{$role->name}}">
                    </div>
                    @foreach ($permissions as $permission)
                    <div class="mb-3 form-check form-check-inline">
                        <label class="form-check-label">
                            <input {{$role->hasPermissionTo($permission->name)?'checked':''}} type="checkbox" name="permission[]" id="per{{$permission->id}}" value="{{$permission->name}}" class="form-check-input">
                            {{$permission->name}}
                        <i class="input-frame"></i></label>
                    </div>
                    @endforeach
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
