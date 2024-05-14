@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Offer-1</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if (session('off1'))
                        <div class="alert alert-success">{{session('off1')}}</div>
                    @endif
                    <form action="{{route('offer1.update',$offer->first()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                     <div class="mb-3">
                        <label class="from-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$offer->first()->title}}">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Price</label>
                        <input type="text" name="price" class="form-control" value="{{$offer->first()->price}}">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Discount Price</label>
                        <input type="text" name="discount_price" class="form-control" value="{{$offer->first()->discount_price}}">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Photo</label>
                        <input type="file" name="photo" class="form-control"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" width="200" src="{{asset('uploads/offer')}}/{{$offer->first()->photo}}" alt="">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{$offer->first()->date}}">
                     </div>
                     <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Offer-2</h3>
                </div>
                <div class="card-body">
                    @if (session('success2'))
                        <div class="alert alert-success">{{session('success2')}}</div>
                    @endif
                    @if (session('off2'))
                        <div class="alert alert-success">{{session('off2')}}</div>
                    @endif
                    <form action="{{route('offer2.update',$offer2->first()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                     <div class="mb-3">
                        <label class="from-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$offer2->first()->title}}">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Sub Title</label>
                        <input type="text" name="sub_title" class="form-control" value="{{$offer2->first()->sub_title}}">
                     </div>
                     <div class="mb-3">
                        <label class="from-label">Photo</label>
                        <input type="file" name="photo" class="form-control"  onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah2" width="200" src="{{asset('uploads/offer')}}/{{$offer2->first()->photo}}" alt="">
                     </div>
                     <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

