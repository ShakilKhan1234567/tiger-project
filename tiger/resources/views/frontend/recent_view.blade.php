@extends('frontend.master')
@section('content')

<!-- start page-title -->
@include('frontend.breadcrums')
<!-- end page-title -->

<!-- start of themart-interestproduct-section -->
<section class="themart-interestproduct-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Recently Viewed Product</h2>
                </div>
                @if (session('recent_view'))
                    <div class="alert alert-info">{{session('recent_view')}}</div>
                @endif
            </div>
        </div>
        <div class="product-wrap">
            <div class="row">
                @foreach ($recents as $recent)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img height="200" src="{{asset('uploads/product/preview')}}/{{$recent->preview_image}}" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="{{route('product.details',$recent->slug)}}">{{$recent->product_name}}</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>130</span>
                            </div>
                            <div class="price">
                                <span class="present-price">{{$recent->after_discount}}</span>
                                <del class="old-price">{{$recent->product_price}}</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="{{route('product.details',$recent->slug)}}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- end of themart-interestproduct-section -->

<!-- start of wpo-site-footer-section -->
<footer class="wpo-site-footer">
    <div class="wpo-upper-footer">
        <div class="container">
            <div class="row">
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget about-widget">
                        <div class="logo widget-title">
                            <img src="assets/images/logo-2.svg" alt="blog">
                        </div>
                        <p>Elit commodo nec urna erat morbi at hac turpis aliquam.
                            In tristique elit nibh turpis. Lacus volutpat ipsum convallis tellus pellentesque
                            etiam.</p>
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="ti-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-twitter-alt"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-linkedin"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-instagram"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Contact Us</h3>
                        </div>
                        <div class="contact-ft">
                            <ul>
                                <li><i class="fi flaticon-mail"></i>themart@gmail.com</li>
                                <li><i class="fi flaticon-phone"></i>(208) 555-0112 <br>(704) 555-0127</li>
                                <li><i class="fi flaticon-pin"></i>4517 Washington Ave. Manchter,
                                    Kentucky 495</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 col-lg-2 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Popular</h3>
                        </div>
                        <ul>
                            <li><a href="product.html">Men</a></li>
                            <li><a href="product.html">Women</a></li>
                            <li><a href="product.html">Kids</a></li>
                            <li><a href="product.html">Shoe</a></li>
                            <li><a href="product.html">Jewelry</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget instagram">
                        <div class="widget-title">
                            <h3>Instagram</h3>
                        </div>
                        <ul class="d-flex">
                            <li><a href="project-single.html"><img src="assets/images/instragram/1.jpg"
                                        alt=""></a></li>
                            <li><a href="project-single.html"><img src="assets/images/instragram/2.jpg"
                                        alt=""></a></li>
                            <li><a href="project-single.html"><img src="assets/images/instragram/4.jpg"
                                        alt=""></a></li>
                            <li><a href="project-single.html"><img src="assets/images/instragram/3.jpg"
                                        alt=""></a></li>
                            <li><a href="project-single.html"><img src="assets/images/instragram/4.jpg"
                                        alt=""></a></li>
                            <li><a href="project-single.html"><img src="assets/images/instragram/1.jpg"
                                        alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    <div class="wpo-lower-footer">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <p class="copyright"> Copyright &copy; 2023 Themart by <a href="index.html">wpOceans</a>.
                        All
                        Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end of wpo-site-footer-section -->
@endsection
