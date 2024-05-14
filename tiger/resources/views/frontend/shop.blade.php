@extends('frontend.master')
@section('content')
     <!-- start wpo-page-title -->
     @include('frontend.breadcrums')
    <!-- end page-title -->

    <!-- product-area-start -->
    <div class="shop-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="shop-filter-wrap">
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <div class="shop-filter-search">
                                    <form>
                                        <div>
                                            <input  id="search_input2" value="{{@$_GET['search_input']}}" type="text" class="form-control" placeholder="Search..">
                                            <button class="search-btn2" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item category-widget">
                                <h2>Filter By Categories</h2>
                                @foreach ($categories as $category)
                                <ul>
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{$category->category_name}} <span>({{App\Models\Product::where('category_id', $category->id)->count()}})</span>
                                            <input class="category" {{$category->id == @$_GET['category_id']?'checked':''}} name="category_id" type="radio" value="{{$category->id}}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>
                                </ul>
                                @endforeach
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter by price</h2>
                                <div class="shopWidgetWraper">
                                    <div class="priceFilterSlider">
                                        <form action="#" method="get" class="clearfix">
                                            <div class="d-flex">
                                                <div class="col-lg-6 pe-2">
                                                    <label for="" class="form-label">Min</label>
                                                    <input value="{{@$_GET['min']}}" id="min" type="text" class="form-control" placeholder="Min">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="form-label">Max</label>
                                                    <input value="{{@$_GET['max']}}" id="max" type="text" class="form-control" placeholder="Max">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <button type="button" class="form-control bg-light range">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Color</h2>
                                <ul>
                                    @foreach ($colors as $color)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{$color->color_name}} <span>({{App\Models\Inventory::where('color_id', $color->id)->count()}})</span>
                                            <input {{$color->id == @$_GET['color_id']?'checked':'' }} class="color4" type="radio" name="color_id" value="{{ $color->id }}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Size</h2>
                                <ul>
                                    @foreach ($sizes as $size)
                                        <li>
                                        <label class="topcoat-radio-button__label">
                                            {{$size->size}} <span>({{App\Models\Inventory::where('size_id', $size->id)->count()}})</span>
                                            <input {{$size->id == @$_GET['size_id']?'checked':'' }} class="size" type="radio" name="size_id" value="{{ $size->id }}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item tag-widget">
                                <h2>Popular Tags</h2>
                                <ul>
                                    @foreach ($tags as $tag)
                                    <li><button class="btn btn-light tag {{$tag->id == @$_GET['tag']?'bg-info':'' }}" value="{{$tag->id}}">{{$tag->tag_name}}</button></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="shop-section-top-inner">
                        <div class="shoping-product">
                            <p>We found <span>{{$products->count()}} items</span> for you!</p>
                        </div>
                        <div class="short-by">
                            <ul>
                                <li>
                                    Sort by:
                                </li>
                                <li>
                                    <select name="sort" class="sort">
                                        <option value="">Default Sorting</option>
                                        <option value="1" {{@$_GET['sort'] == 1?'selected':''}}>Price Low To High</option>
                                        <option value="2" {{@$_GET['sort'] == 2?'selected':''}}>Price High To Low</option>
                                        <option value="3" {{@$_GET['sort'] == 3?'selected':''}}>A-Z</option>
                                        <option value="4" {{@$_GET['sort'] == 4?'selected':''}}>Z-A</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="row align-items-center">
                            @forelse ($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="product-item">
                                    <div class="image">
                                        <img height="200" src="{{asset('uploads/product/preview')}}/{{$product->preview_image}}" alt="">
                                        <div class="tag new">New</div>
                                    </div>
                                    <div class="text">
                                        <h2><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h2>
                                        <div class="rating-product">
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <i class="fi flaticon-star"></i>
                                            <span>130</span>
                                        </div>
                                        <div class="price">
                                            <span class="present-price">&#2547;{{$product->after_discount}}</span>
                                            <del class="old-price">&#2547;{{$product->product_price}}</del>
                                        </div>
                                        <div class="shop-btn">
                                            <a class="theme-btn-s2" href="{{route('product.details', $product->slug)}}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                               <h3>No Search product Found</h3>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-area-end -->
@endsection
