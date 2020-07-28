@extends('system._layouts.main')

@section('content')
<div class="row px-5 py-4">
  <div class="col-12">
    @include('system._components.notifications')
    <div class="row ">
      <div class="col-md-6">
        <h5 class="text-title text-uppercase">{{$page_title}}</h5>
      </div>
      <div class="col-md-6 ">
        <p class="text-dim  float-right">EOR-PHP Processor Portal / Applications / Application Details</p>
      </div>
    </div>
  </div>
  <div class="col-12 pt-4">
    <div class="card card-rounded shadow-sm">
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-1 text-center">
            <img src="{{asset('system/images/default.jpg')}}" class="rounded-circle" width="100%">
          </div>
          <div class="col-md-11 d-flex">
            <p class="text-title fw-500 pt-3">Application by: <span class="text-black">{{Str::title($application->name)}}</span></p>
            <p class="text-title fw-500 pl-3" style="padding-top: 15px;">|</p>
            <p class="text-title fw-500 pt-3 pl-3">Application Sent: <span class="text-black">{{ Helper::date_format($application->created_at)}}</span></p>
          </div>
        </div> 
      </div>
     
      <div class="card-body" style="border-bottom: 3px dashed #E3E3E3;">
        <div class="row">
          <div class="col-md-6">
            <p class="text-title fw-500">Applying For: <span class="text-black">{{$application->type->name}}</span></p>
            <p class="text-title fw-500">Email Address: <span class="text-black">{{$application->email}}</span></p>
          </div>
          <div class="col-md-6">
            <p class="text-title fw-500">Deparatment/Agency: <span class="text-black">{{$application->department->name}}</span></p>
            <p class="text-title fw-500">Contact Number: <span class="text-black">+63{{$application->contact_number}}</span></p>
          </div>  
         
        </div> 
        <p class="fw-500" style="color: #DC3C3B;">Amount: Php {{Helper::money_format($application->amount)}}</p>
      </div>
      <div class="card-body d-flex">
        <button class="btn btn-transparent p-3" data-toggle="collapse" data-target="#collapseExample"><i class="fa fa-download" style="font-size: 1.5rem;"></i></button>
        <p class="text-title pt-4 pl-3 fw-500">Review Attached Requirements : {{$count_file}} Item/s</p>
      </div>
    </div>
    <div class="collapse pt-2" id="collapseExample">
      <div class="card card-body card-rounded">
        <div class="row justify-content-center">
          @forelse($attachments as $index => $attachment)
          <div class="col-md-3">
            <div class="card card-rounded h-100">
                <div class="card-body text-center">
                    <code style="color: black;">Attachments # {{$index + 1}}</code>
                    <p><i class="fa {{$attachment->type == "file" ? "fa-file-pdf" : "fa-image"}} fa-5x mt-2"></i></p>
                    <p class="card-title">{{$attachment->original_name}}</p>
                    @if($attachment->type == "file")
                      <a href="{{$attachment->directory}}/{{$attachment->filename}}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                    @else
                      <a href="#checkImage" data-toggle="modal" data-myimage="{{$attachment->directory}}/{{$attachment->filename}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                    @endif
                </div>
            </div>
          </div>
          @empty
            <h5>No Items available.</h5>
          @endforelse
        </div>
      </div>
    </div>  

    <a  data-url="{{route('system.application.process',[$application->id])}}?status_type=approved" data-toggle="modal" data-target="#confirm-process" class="btn btn-primary mt-4 border-5 text-white action-process"><i class="fa fa-check-circle"></i> Approved Application</a>
    <a  data-url="{{route('system.application.process',[$application->id])}}?status_type=declined" data-toggle="modal" data-target="#confirm-process" class="btn btn-danger mt-4 border-5 text-white action-process"><i class="fa fa-times-circle"></i> Declined Application</a>
  </div>
  
</div>
@stop

@section('page-modals')
<div id="confirm-process" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm your action</h5>
      </div>

      <div class="modal-body">
        <h6 class="text-semibold">Processing Record...</h6>
        <p>You are about to process a record, this action can no longer be undone, are you sure you want to proceed?</p>

        <hr>

        <h6 class="text-semibold">What is this message?</h6>
        <p>This dialog appears everytime when the chosen action could hardly affect the system. Usually, it occurs when the system is issued a delete command.</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-sm btn-primary" id="btn-confirm-process">Process</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="checkImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
        <img src="" class="imagepreview" alt="bank_chalan" id="thanks" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
<style type="text/css" >
  .input-daterange input{ background: #fff!important; }  
</style>
@stop

@section('page-scripts')
<script src="{{asset('system/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
  $(function(){
    $('.input-daterange').datepicker({
      format : "yyyy-mm-dd"
    });

    $(".action-process").on("click",function(){
      var btn = $(this);
      $("#btn-confirm-process").attr({"href" : btn.data('url')});
    });

    $('#checkImage').on('show.bs.modal', function (e) {
      var img = $(e.relatedTarget).data('myimage');
      //alert(img);
      $("#thanks").attr("src", img);
    });  
  })
</script>
@stop