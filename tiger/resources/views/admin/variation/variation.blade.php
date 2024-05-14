@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card bg-success">
            <div class="card-header">
                <h3>Variation List</h3>
            </div>
            <div class="card-body">
                @if (session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Color Name</th>
                        <th>Color Code</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($variations as $sl=>$variation)
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$variation->color_name}}</td>
                        <td>
                           <h6 style="height: 35px; width:35px; background-color:{{$variation->color_name == 'NA'?'':$variation->color_code}}; color:{{$variation->color_name == 'NA'?$variation->color_name:'transparent'}}">{{$variation->color_name == 'NA'?$variation->color_name:''}}</h6>
                        </td>
                        <td>
                            <a href="{{route('delete.variation',$variation->id)}}" type="button" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mt-5 bg-light">
            <div class="card-header">
                <h3>Size List</h3>
            </div>
            <div class="card-body">
                @if (session('delete_size'))
                    <div class="alert alert-success">{{session('delete_size')}}</div>
                @endif
              <div class="row">
                @foreach ($categories as $category)
                <div class="col-lg-6 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{$category->category_name}}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Size Name</th>
                                    <th>Action</th>
                                </tr>
                                @foreach (App\Models\Size::where('category_id', $category->id)->get() as $size)
                                    <tr>
                                        <td>{{$size->size}}</td>
                                    <td>
                                        <a href="{{route('delete.size',$size->id)}}" type="button" class="btn btn-danger btn-icon">
                                            <i data-feather="trash"></i>
                                        </a>
                                    </td>
                                    </tr>
                                @endforeach
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
                <h3>Add Colour</h3>
            </div>
            <div class="card-body">
                <form action="{{route('variation.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Color Name</label>
                       <input type="text" name="color_name" class="form-control">
                       @error('color_name')
                           <div class="alert alert-success mt-2">{{$message}}</div>
                       @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Code</label>
                       <input type="text" name="color_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Colour</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Add Size</h3>
            </div>
            <div class="card-body">
                <form action="{{route('size')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Size</label>
                       <input type="text" name="size" class="form-control">
                       @error('size')
                           <div class="alert alert-success mt-2">{{$message}}</div>
                       @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
