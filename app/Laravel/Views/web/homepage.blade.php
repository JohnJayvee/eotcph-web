@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="team-section ptb-120 home-bg ">
    <div class="container">
        <div class="row ">
            <div class="col-md-4 col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="letter-spacing: 3px;"><i class="fa fa-file"></i> E<span class="font-weight-lighter">SUBMISSION</span></h5>
                    </div>
                     <div class="col-lg-12">
                        <a href="{{route('web.application.create')}}" class="btn btn-white"> <i class="fa fa-laptop"></i> Submit</a>
                    </div>
                    <div class="col-lg-12 pt-4">
                        <h5 style="letter-spacing: 3px;"><i class="fa fa-calculator"></i> E<span class="font-weight-lighter">PAYMENT</span></h5>
                    </div>
                    <div class="col-lg-12 pt-2">
                       <input type="" name="" class="form-control input-transparent" placeholder="Enter Transaction Code">
                    </div>
                    <div class="col-lg-12 pt-4">
                        <a href="" class="btn btn-white"> <i class="fa fa-money-bill"></i> Pay</a>
                    </div>
                    <div class="col-lg-12 pt-4">
                        <h5 style="letter-spacing: 3px;"><i class="fa fa-th-large"></i> REQUEST<span class="font-weight-lighter"> EOR</span></h5>
                    </div>
                    <div class="col-lg-12 pt-2">
                       <input type="" name="" class="form-control input-transparent" placeholder="Enter Transaction Code">
                    </div>
                    <div class="col-lg-12 pt-2">
                       <input type="" name="" class="form-control input-transparent" placeholder="Enter Email Address">
                    </div>
                    <div class="col-lg-12 pt-4">
                        <a href="" class="btn btn-white"> <i class="fa fa-file"></i> Request</a>
                    </div>
                </div>
            </div>
           
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
</script>
@endsection