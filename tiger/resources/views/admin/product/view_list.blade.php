@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Add New Product</h3>
                <a href="{{route('product.list')}}" class="btn btn-primary"><i data-feather="list"></i>Product List</a>
            </div>
            <div class="card-body">
                @if (session('product'))
                    <div class="alert alert-success">{{session('product')}}</div>
                @endif
              <form action="{{route('product.update', $products->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Sub Category</label>
                        <select name="subcategory_id" class="form-control subcategory">
                            <option value="">Select SubCategory</option>
                            @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-control">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option {{$products->brand_id == $brand->id?'selected':''}} value="{{$brand->id}}">{{$brand->brand_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" value="{{$products->product_name}}">
                        @error('product_name')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Product Price</label>
                        <input type="number" name="product_price" class="form-control" value="{{$products->product_price}}">
                        @error('product_price')
                            <div class="alert alert-danger mt-2">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" value="{{$products->discount}}">
                    </div>
                    <div class="col-lg-12 mt-2">
                        <label class="form-label">Tags</label>
                        <input type="text" id="input-tags" name="tags[]" class="form-control border-0 px-0" value="{{$products->tags}}">
                    </div>
                    <div class="col-lg-12 mt-3">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_desp" class="form-control" value="{!!$products->short_desp!!}">
                        @error('short_desp')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="col-lg-12 mt-2">
                        <label class="form-label">Long Description</label>
                        <textarea id="summernote" name="long_desp" cols="30" rows="10" class="form-control">{!!$products->long_desp!!}</textarea>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <label class="form-label">Additional Information</label>
                        <textarea id="summernote2" name="additional_info" cols="30" rows="10" class="form-control">{!!$products->additional_info!!}</textarea>
                    </div>
                    <div class="col-lg-6 mt-2">
                        <label class="form-label">Preview Image</label>
                        <input type="file" name="preview_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img src="{{asset('uploads/product/preview')}}/{{$products->preview_image}}" width="150" id="blah" alt="">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-control">Current Gallery Image</label>
                        @foreach ($galleries as $gallery)
                            <img width="150" src="{{asset('uploads/product/gallery')}}/{{$gallery->gallery_image}}" alt="">
                            @endforeach
                    </div>
                    <div class="col-lg-12 mt-2">
                    <div class="upload__box">
                        <div class="upload__btn-box">
                            <span class="d-block pb-2">Gallery Images</span>
                          <label class="upload__btn">
                            <p>Upload Product Gallery images</p>
                            <input type="file" name="gallery_image[]" multiple="" data-max_length="20" class="upload__inputfile">
                          </label>
                        </div>
                        <div class="upload__img-wrap"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 m-auto ">
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary w-100">Update Product</button>
                        </div>
                    </div>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_script')
<script>
    $("#input-tags").selectize({
    delimiter: ",",
    persist: false,
    create: function (input) {
    return {
        value: input,
        text: input,
    };
    },
    });
</script>
<script>
    $('.category').change(function(){
        var category_id = $(this).val();

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
      type:'POST',
      url:'/getSubcategory',
      data:{'category_id':category_id},
        success: function (data) {
        $('.subcategory').html(data);
        }
    })

})
</script>
<script>
    $(document).ready(function() {
    $('#summernote').summernote();
    $('#summernote2').summernote();
    });
</script>
<script>
    jQuery(document).ready(function () {
  ImgUpload();
});

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
</script>
@endsection

