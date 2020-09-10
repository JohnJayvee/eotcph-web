@extends('web._layouts.main')


@section('content')



<!--team section start-->
<section class="px-120 pt-110 pb-80 gray-light-bg">
    <div class="container">
         
         <div class="row flex-row items-center px-4">
            <h5 class="text-title pb-3"><i class="fa fa-file"></i> E<span class="text-title-two"> APPLICATION HISTORY</span></h5>
            <a href="{{route('web.transaction.history')}}" class="custom-btn badge-primary-2 text-white " style="float: right;margin-left: auto;">E-Submission</a>
         </div>
          
        <div class="card">
        <table class="table table-striped table-font">
            <thead>
              <tr>
                <th width="25%" class="text-title fs-15 fs-500 p-3">Company Name</th>
                <th width="25%" class="text-title fs-15 fs-500 p-3">Application</th>
                <th width="15%" class="text-title fs-15 fs-500 p-3">Processing Fee</th>
                <th width="15%" class="text-title fs-15 fs-500 p-3">Status</th>
                <th width="20%" class="text-title fs-15 fs-500 p-3">Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $transaction)
              <tr>
                <td>{{$transaction->company_name}}</th>
                <td>{{$transaction->type->name}}<br><a href="{{route('web.transaction.show',[$transaction->id])}}}">{{$transaction->code}}</a></th>
                <td style="text-align: center;">{{$transaction->processing_fee}}<p class="btn-status btn-sm bg-warning text-white">{{$transaction->payment_status}}</p></th>
                <td><p class="btn text-white {{Helper::status_color($transaction->status)}}">{{Str::title($transaction->transaction_status)}}</p></td>
                <td>{{Helper::date_format($transaction->created_at)}}</td>
              </tr>
              @empty
              <tr>
               <td colspan="5" class="text-center"><i>No transaction Records Available.</i></td>
              </tr>
              @endforelse
              
            </tbody>
        </table>
        </div>
        
    </div>

</section>
<!--team section end-->


@stop
@section('page-styles')
<style type="text/css">
    .custom-btn{
        padding: 5px 10px;
        border-radius: 10px;
        height: 37px;
    }
    .custom-btn:hover{
        background-color: #7093DC !important;
        color: #fff !important;
    }
    .btn-status{
        text-align: center;
        border-radius: 10px;
    }
    .table-font th{
        font-size: 16px;
        font-weight: bold;
    }
    .table-font td{
        font-size: 13px;
        font-weight: bold;
    }
</style>
@endsection
