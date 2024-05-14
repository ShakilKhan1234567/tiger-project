@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <form action="{{route('restore.all')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    @if (session('restore_all'))
                        <div class="alert alert-success">{{session('restore_all')}}</div>
                    @endif
                    @if (session('permanent_delete'))
                        <div class="alert alert-success">{{session('permanent_delete')}}</div>
                    @endif
                    @if (session('category_restore'))
                        <div class="alert alert-success">{{session('category_restore')}}</div>
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
                        @forelse($categories as $key=>$category)
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
                                <a title="Restore" href="{{route('restore.category',$category->id)}}" type="button" class="btn btn-success btn-icon">
                                    <i data-feather="rotate-cw"></i>
                                </a>
                                <a title="permanent delete" href="{{route('permanent.delete.category',$category->id)}}" type="button" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"><h4 class="text-center text-danger">No Trash Category Found</h4></td>
                        </tr>
                        @endforelse
                    </table>
                    <div class="my-2">
                        <button type="submit" name="checked" value="1" class="btn btn-primary">Restore All</button>
                        <button type="submit" name="checked" value="2" class="btn btn-danger">Delete All</button>
                     </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer_script')
<script>
    $("#chkSelectAll").on('click', function(){
    this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
})
</script>
@endsection
