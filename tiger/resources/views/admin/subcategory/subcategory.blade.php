@extends('layouts.admin')
@section('content')
@can('subcategory_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Subcategory List</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <div class="row">
                 @foreach ($categories as $category)
                 <div class="col-lg-6 my-2">
                 <div class="card">
                    <div class="card-header">
                        <h4>{{$category->category_name}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Sub Category</th>
                                <th>Action</th>
                            </tr>
                            @forelse (App\Models\Subcategory::where('category_id', $category->id)->get() as $subcategory)
                            <tr>
                                <td>{{$subcategory->subcategory_name}}</td>
                                <td>
                                    <a href="{{route('edit.subcategory',$subcategory->id)}}" type="button" class="btn btn-primary btn-icon">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <a type="button" class="btn btn-danger btn-icon del_btn" data-link="{{route('delete.subcategory',$subcategory->id)}}">
                                        <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                             <td colspan="2"><h6 class="text-center text-warning">No Subcategory Found</h6></td>
                            </tr>
                            @endforelse
                         </table>
                    </div>
                 </div>
                   </div>
                 @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New SubCategory</h3>
            </div>
            <div class="card-body">
                @if (session('exist'))
                    <div class="alert alert-success">{{session('exist')}}</div>
                @endif
                @if (session('sub_cat'))
                    <div class="alert alert-success">{{session('sub_cat')}}</div>
                @endif
              <form action="{{route('subcategory.store')}}" method="POST">
                @csrf
                <div class="mt-2">
                    <select name="select_category" class="form-control">
                        <option value="">Select Category</option>
                         @foreach ($categories as $category)
                         <option value="{{$category->id}}">{{$category->category_name}}</option>
                         @endforeach
                    </select>
                    @error('select_category')
                    <div class="alert alert-danger mt-2">{{$message}}</div>
                @enderror
                </div>
                <div class="mt-2">
                    <label class="form-label">Subcategory name</label>
                    <input type="text" name="subcategory_name" class="form-control">
                    @error('subcategory_name')
                        <div class="alert alert-danger mt-2">{{$message}}</div>
                    @enderror
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">Add Subcategory</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
@section('footer_script')
<script>
$('.del_btn').click(function(){
  var link = $(this).attr('data-link');

    Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
    if (result.isConfirmed) {
        window.location.href = link;
    }
    })
})
</script>
<script>
    if(session('success')){
        Swal.fire(
        'Deleted!',
        '{{session('success')}}',
        'success'
    )
    }
</script>
@endsection
