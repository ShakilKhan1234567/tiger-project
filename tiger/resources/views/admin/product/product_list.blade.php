@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Product List</h3>
                <a href="{{route('add.product')}}" class="btn btn-primary"><i data-feather="plus"></i>Add New Product</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Discount(%)</th>
                        <th>After Discount</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $sl=>$product)
                        <tr>
                            <td>{{$products->firstitem()+$sl}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_price}}</td>
                            <td>{{$product->discount}}</td>
                            <td>{{$product->after_discount}}</td>
                            <td>
                                <img src="{{asset('uploads/product/preview')}}/{{$product->preview_image}}" alt="">
                            </td>
                            <td>
                                <input type="checkbox" {{$product->status == 1?'checked':''}} data-id="{{$product->id}}" class="status" value="{{$product->status}}" data-toggle="toggle">
                            </td>
                            <td>
                                <a title="inventory" href="{{route('add.inventory',$product->id)}}" type="button" class="btn btn-info btn-icon">
                                    <i data-feather="layers"></i>
                                </a>
                                <a title="view all" href="{{route('view.list',$product->id)}}" type="button" class="btn btn-success btn-icon">
                                    <i data-feather="eye"></i>
                                </a>
                                <a href="{{route('list.delete',$product->id)}}" type="button" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="mt-3">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
<script>
    $('.status').change(function (){

        if($(this).val() != 1){
            $(this).attr('value', 1)
        }
        else{
            $(this).attr('value', 0)
        }
      var product_id = $(this).attr('data-id');
      var status = $(this).val();


    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
        url:'/getstatus',
        type:'POST',
        data:{'product_id':product_id, 'status':status},
        success: function (data){

        }
    })

})
</script>
@endsection
