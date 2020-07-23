@extends('web._layouts.main')


@section('content')
<!--user registration start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
         <h5 class="text-title pb-3"><i class="fa fa-pencil-alt"></i> CREATE ACCOUNT</h5>
        <div class="card login-signup-form" style="border-radius: 8px;">
            <form method="POST" action="" enctype="multipart/form-data">
            {!!csrf_field()!!}
                <div class="card-body pl-5 py-5">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="text-form pb-2">First Name</label>
                                <input type="text" class="form-control {{ $errors->first('fname') ? 'is-invalid': NULL  }} form-control-sm" name="fname" placeholder="Firstname" value="{{old('fname')}}">
                                 @if($errors->first('fname'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('fname')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group mb-0">
                                <label class="text-form pb-2">Last Name</label>
                                <input type="text" class="form-control {{ $errors->first('lname') ? 'is-invalid': NULL  }} form-control-sm" name="lname" placeholder="Lastname" value="{{old('lname')}}">
                                @if($errors->first('lname'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('lname')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="text-form pb-2">Email</label>
                                <input type="email" class="form-control {{ $errors->first('email') ? 'is-invalid': NULL  }} form-control-sm" name="email" placeholder="Email Address" value="{{old('email')}}">
                                @if($errors->first('email'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="text-form pb-2">Contact Number</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                    </div>
                                    <input type="text" class="form-control {{ $errors->first('contact_number') ? 'is-invalid': NULL  }} br-left-white" name="contact_number" placeholder="Contact Number" value="{{old('contact_number')}}">
                                    
                                </div>
                                @if($errors->first('contact_number'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('contact_number')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="text-form pb-2">Password</label>
                                <input type="password" class="form-control {{ $errors->first('password') ? 'is-invalid': NULL  }} form-control-sm" name="password" placeholder="Password">
                                @if($errors->first('password'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('password')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="text-form pb-2">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn secondary-solid-btn px-4 fs-14 mt-4"><i class="fa fa-user-plus pr-2"></i>Create Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!--user registration end-->

<div id="gwt-standard-footer"></div>
@stop

<div class="modal fade" id="myModal">
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header justify-content-center">
            <img src="{{asset('web/img/correct.png')}}" alt="logo" class="img-fluid text-center" width="30%" />
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center">
            <h4>Great!</h4> 
            <p>Your account has been created successfully.</p>
            <button class="btn outline-btn" data-dismiss="modal"><span>Close</span></button>
        </div>
        <!-- Modal footer -->
      </div>
    </div>
</div>

@section('page-scripts')
<script type="text/javascript">
    (function(d, s, id) {
    var js, gjs = d.getElementById('gwt-standard-footer');

    js = d.createElement(s); js.id = id;
    js.src = "//gwhs.i.gov.ph/gwt-footer/footer.js";
    gjs.parentNode.insertBefore(js, gjs);
    }(document, 'script', 'gwt-footer-jsdk'));

    $('#file').change(function(e){
      var fileName = e.target.files[0].name;
      $('#lblName').text(fileName);
    });
</script>
@endsection
