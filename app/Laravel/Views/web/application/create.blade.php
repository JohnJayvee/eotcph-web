@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
         <h5 class="text-title pb-3"><i class="fa fa-file"></i> E<span class="text-title-two"> SUBMISSION</span></h5>
          @include('web._components.notifications')
        <div class="card">
            <form method="POST" action="" enctype="multipart/form-data">
            {!!csrf_field()!!}
           
                <div class="card-body px-5 py-0">
                    <h5 class="text-title text-uppercase pt-5">Application information</h5>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Your Name</label>
                                <input type="text" class="form-control form-control-sm {{ $errors->first('full_name') ? 'is-invalid': NULL  }}"  placeholder="Last Name, First Name, Middle Name" name="full_name" value="{{old('full_name') ?:$auth->name}}">
                                @if($errors->first('full_name'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('full_name')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Company Name</label>
                                <input type="text" class="form-control form-control-sm {{ $errors->first('company_name') ? 'is-invalid': NULL  }}" placeholder="Company Name" name="company_name" value="{{old('company_name')}}">
                                @if($errors->first('company_name'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('company_name')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Department/Agency</label>
                                {!!Form::select("department_id", $department, old('department_id'), ['id' => "input_department_id", 'class' => "form-control form-control-sm classic ".($errors->first('department_id') ? 'border-red' : NULL)])!!}

                               
                            </div>
                            @if($errors->first('department_id'))
                                <small class="form-text pl-1" style="color:red;">{{$errors->first('department_id')}}</small>
                            @endif
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Applying For</label>
                                {!!Form::select('purpose',['' => "--Choose Application Type--"],old('purpose'),['id' => "input_purpose",'class' => "form-control form-control-sm classic ".($errors->first('purpose') ? 'border-red' : NULL)])!!}
                               
                            </div>
                            @if($errors->first('purpose'))
                                <small class="form-text pl-1" style="color:red;">{{$errors->first('purpose')}}</small>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Amount to pay</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text text-title fw-600">PHP <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                  </div>
                                  <input type="number" class="form-control br-left-white br-right-white {{ $errors->first('amount') ? 'is-invalid': NULL  }}" placeholder="Payment Amount" name="amount" value="{{old('amount')}}">
                                  <div class="input-group-append">
                                    <span class="input-group-text text-title fw-600">| <span class="text-gray pl-2 pr-2 pt-1"> .00</span></span>
                                  </div>
                                </div>
                                @if($errors->first('amount'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('amount')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Your Email Address</label>
                                <input type="text" class="form-control form-control-sm" name="email" placeholder="Email Address" value="{{old('email') ?:$auth->email}}">
                                @if($errors->first('email'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('email')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-form pb-2">Contact Number</label>
                                <div class="input-group mb-3">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text text-title fw-600">+63 <span class="pr-1 pl-2" style="padding-bottom: 2px"> |</span></span>
                                  </div>
                                  <input type="text" class="form-control br-left-white" placeholder="Contact Number" name="contact_number" value="{{old('contact_number') ?:$auth->contact_number}}">
                                </div>
                                @if($errors->first('contact_number'))
                                    <small class="form-text pl-1" style="color:red;">{{$errors->first('contact_number')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h5 class="text-title text-uppercase pt-3">Upload Requirements</h5>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <label class="text-form pb-2">Application Requirements</label>
                            <div class="form-group">
                                <div class="upload-btn-wrapper">
                                    <button class="btn vertical" style="color: #ADADAD">
                                        <i class="fa fa-upload fa-4x" ></i>
                                        <span class="pt-1">Upload Here</span>
                                    </button>
                                    <input type="file" name="file" class="form-control" id="file">
                                </div>
                                @if($errors->first('file'))
                                    <label style="vertical-align: top;padding-top: 40px;color: red;" class="fw-500 pl-3">{{$errors->first('file')}}</label>
                                @else
                                    <label id="lblName" style="vertical-align: top;padding-top: 40px;" class="fw-500 pl-3"></label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="form pt-0">
                <div class=" card-body px-5 pb-5">
                    <h5 class="text-title text-uppercase ">Print Requirements</h5>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customControlValidation1" name="is_check" value="yes">
                        <label class="custom-control-label fs-12 fw-600 text-black" for="customControlValidation1">&nbsp;&nbsp; Check this option to receive printable application form with QRCode which will be sent physically</label>
                        
                    </div>
                    <button class="btn badge badge-primary-2 text-white px-4 py-2 fs-14" type="submit"><i class="fa fa-paper-plane pr-2"></i>  Send Application</button>
                </div>
            </form>
        </div>
        
    </div>

</section>
<!--team section end-->
<div id="gwt-standard-footer"></div>

@stop

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


    $.fn.get_application_type = function(department_id,input_purpose,selected){
        $(input_purpose).empty().prop('disabled',true)
        $(input_purpose).append($('<option>', {
                  value: "",
                  text: "Loading Content..."
              }));
        $.getJSON( "{{route('web.get_application_type')}}?department_id="+department_id, function( result ) {
            $(input_purpose).empty().prop('disabled',true)
            $.each(result.data,function(index,value){
              // console.log(index+value)
              $(input_purpose).append($('<option>', {
                  value: index,
                  text: value
              }));
            })

            $(input_purpose).prop('disabled',false)
            $(input_purpose).prepend($('<option>',{value : "",text : "--Choose Further Sub Category--"}))

            if(selected.length > 0){
              $(input_purpose).val($(input_purpose+" option[value="+selected+"]").val());

            }else{
              $(input_purpose).val($(input_purpose+" option:first").val());
              //$(this).get_extra(selected)
            }
        });
        // return result;
    };


    $("#input_department_id").on("change",function(){
      var department_id = $(this).val()
      $(this).get_application_type(department_id,"#input_purpose","")
      
    })

    @if(old('purpose'))
        $(this).get_application_type("{{old('department_id')}}","#input_purpose","{{old('purpose')}}")
    @endif
</script>

@endsection