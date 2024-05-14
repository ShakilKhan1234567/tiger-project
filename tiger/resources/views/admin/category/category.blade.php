@extends('layouts.admin');
@section('content')
@can('category_access')
<div class="row">
    <div class="col-lg-8">
       <form action="{{route('checked.delete')}}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3>Category List</h3>
            </div>
            <div class="card-body">
                @if (session('category_delete'))
                    <div class="alert alert-success">{{session('category_delete')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" id="chkSelectAll" class="form-check-input">
                                Checked All
                            <i class="input-frame"></i></label>
                        </div>
                        </th>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Icon</th>
                        <th>Action</th>
                    </tr>
                @foreach ($categories as $key=>$category)
                <tr>
                    <td>
                       <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="check[]" class="form-check-input chkDel" value="{{$category->id}}">
                        <i class="input-frame"></i></label>
                       </div>
                    </td>
                    <td>{{$key+1}}</td>
                    <td>{{$category->category_name}}</td>
                    <td>
                        <img src="{{asset('uploads/category')}}/{{$category->icon}}" alt="">
                    </td>
                    <td>
                        @can('category_edit')
                        <a href="{{route('edit.category',$category->id)}}" type="button" class="btn btn-primary btn-icon">
                            <i data-feather="edit"></i>
                        </a>
                        @endcan
                        @can('category_delete')
                        <a href="{{route('delete.category',$category->id)}}" type="button" class="btn btn-danger btn-icon">
                            <i data-feather="trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
                </table>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Delete Checked</button>
                </div>
            </div>
        </div>
       </form>
    </div>
    @can('category_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Category Add</h3>
            </div>
            <div class="card-body">
                @if (session('category_add'))
                <div class="alert alert-success">{{session('category_add')}}</div>
               @endif
                <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="my-2">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-control" name="category_name">
                    @error('category_name')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-2">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" name="icon">
                    @error('icon')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="my-2">
                   <button type="submit" class="btn btn-primary">Category Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endcan
@endsection

@section('footer_script')
<script>
    $("#chkSelectAll").on('click', function(){
    this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
})
</script>
@endsection
