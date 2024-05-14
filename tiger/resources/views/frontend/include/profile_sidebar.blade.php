<div class="col-lg-3 text-center">
    <div class="card">
        @if (Auth::guard('customer')->user()->photo == null)
                    <img width="70" class="py-2 m-auto" src="{{ Avatar::create(Auth::guard('customer')->user()->fname.' '.Auth::guard('customer')->user()->lname)->toBase64() }}"/>
                    @else
                    <img width="100" class="py-2 m-auto" src="{{asset('uploads/customer')}}/{{Auth::guard('customer')->user()->photo}}"/>
        @endif
        <div class="card-body">
          <h5 class="card-title">{{Auth::guard('customer')->user()->fname.' '.Auth::guard('customer')->user()->lname}}</h5>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item py-3 bg-light"><a class="text-dark" href="{{route('customer.profile')}}">Profile</a></li>
          <li class="list-group-item py-3 bg-light"><a class="text-dark" href="{{route('my.orders')}}">My Order</a></li>
          <li class="list-group-item py-3 bg-light"><a class="text-dark" href="">My Whistlist</a></li>
          <li class="list-group-item py-3 bg-light"><a class="text-dark" href="{{route('customer.logout')}}">Logout</a></li>
        </ul>
      </div>
</div>
