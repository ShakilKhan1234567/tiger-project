@extends('frontend.master')
@section('content')
 <!-- start wpo-faq-section -->
 <section class="wpo-faq-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 offset-lg-2">
                <div class="wpo-section-title">
                    <h2>Frequently Asked Question</h2>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-2">
                <div class="wpo-faq-wrap">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="wpo-benefits-item">
                                <div class="accordion" id="accordionExample">
                                    @foreach ($faqs as $faq)
                                    <div class="accordion-item">
                                        <h3 class="accordion-header" id="aa{{$faq->id}}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#bb{{$faq->id}}"
                                                aria-expanded="false" aria-controls="bb{{$faq->id}}">
                                                {{$faq->question}}
                                            </button>
                                        </h3>
                                        <div id="bb{{$faq->id}}" class="accordion-collapse collapse"
                                            aria-labelledby="aa{{$faq->id}}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p>{{$faq->answer}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</section>
<!-- end faq-section -->
@endsection
