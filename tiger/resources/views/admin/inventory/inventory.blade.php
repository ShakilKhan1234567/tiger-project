@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Inventory for, <strong>{{$products->product_name}}</strong></h3>
                <a href="{{route('product.list')}}" class="btn btn-primary"><i data-feather="list"></i>Go Back To List</a>
            </div>
            <div class="card-body">
                @if (session('inventory'))
                    <div class="alert alert-success">{{session('inventory')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{$inventory->rel_to_variation->color_name}}</td>
                        <td>{{$inventory->rel_to_size->size}}</td>
                        <td>{{$inventory->quantity}}</td>
                        <td>
                            <a href="{{route('delete.inventory',$inventory->id)}}" type="button" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </a>
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
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                @if (session('insert'))
                    <div class="alert alert-success">{{session('insert')}}</div>
                @endif
                <form action="{{route('inventory.store',$products->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <input type="text" disabled class="form-control" value="{{$products->product_name}}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Color</label>
                        <select name="color_id" class="form-control">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                            <option value="{{$color->id}}">{{$color->color_name}}</option>
                            @endforeach
                        </select>
                        @error('color_id')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Size</label>
                        <select name="size_id" class="form-control">
                            <option value="">Select Size</option>
                            @foreach (App\Models\Size::where('category_id', $products->category_id)->get() as $size)
                            <option value="{{$size->id}}">{{$size->size}}</option>
                            @endforeach
                        </select>
                        @error('size_id')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Add Quantity</label>
                        <input type="text" name="quantity" class="form-control">
                        @error('quantity')
                        <div class="alert alert-success mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
