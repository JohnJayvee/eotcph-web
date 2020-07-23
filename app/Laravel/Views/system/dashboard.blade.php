@extends('system._layouts.main')

@section('content')
<div class="row">
	<div class="col-12">
        @include('system._components.notifications')
	</div>
</div>
<div class="container p-4">
	<h5 class="text-title text-uppercase">Dashboard</h5>
	<p class="text-sub-title fw-500 pt-2">Today's Daily Summary</p>
	<div class="row">
	    <div class="col-md-3">
	      <div class="card-counter info">
	        <i class="fa fa-hourglass-half"></i>
	        <span class="count-numbers">{{$pending}}</span>
	        <span class="count-name">Pending Applications</span>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="card-counter success">
	        <i class="fa  fa-check-circle"></i>
	        <span class="count-numbers">{{$approved}}</span>
	        <span class="count-name">Approved Applications</span>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="card-counter primary">
	        <i class="fa fa-file"></i>
	        <span class="count-numbers">{{$application_today}}</span>
	        <span class="count-name">Total Daily Applications</span>
	      </div>
	    </div>
	    <div class="col-md-3">
	      <div class="card-counter danger">
	        <i class="fa fa-times-circle"></i>
	        <span class="count-numbers">{{$declined}}</span>
	        <span class="count-name">Disapproved Applications</span>
	      </div>
	    </div>
	</div>
	<div class="row pt-2">
		<div class="col-md-6 p-2">
			<div class="card" style="border: none;border-radius: 10px;">
				<div class="card-body">
					<h5 class="text-title d-inline-block p-3">Monthly Summary</h5>
					<div id="bar-example" ></div>
				</div>
			</div>
		</div>
		<div class="col-md-6 p-2">
			<div class="card" style="border: none;border-radius: 10px;">
				<div class="card-body">
					<h5 class="text-title d-inline-block p-3">Current Average</h5>
					<div class="row pl-4">
						<div class="col-md-7">
							<canvas id='myChart' height="410"></canvas>
						</div>
						<div class="col-md-5">
							<div id="js-legend" class="chart-legend"></div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="row pt-2">
		<div class="col-md-12">
			<div class="table-responsive shadow-sm fs-15">
				<table class="table table-striped">
					<thead>
					    <tr>
					      <th width="25%" class="text-title fs-15 fs-500 p-3">Applicant Name</th>
					      <th width="25%" class="text-title fs-15 fs-500 p-3">Company Name</th>
					      <th width="25%" class="text-title fs-15 fs-500 p-3">Purpose</th>
					      <th width="15%" class="text-title fs-15 fs-500 p-3">Status</th>
					      <th width="10%" class="text-title fs-15 fs-500 p-3">Action</th>
					    </tr>
					</thead>
					<tbody>
						@forelse($applications as $application)
							<th>{{$application->name}}</th>
							<th>{{$application->company_name}}</th>
							<th>{{$application->type->name}}</th>
							<td><p class="btn text-white" style="background-color: #EF9E06">{{Str::title($application->status)}}</p></td>
							<td >
								<button type="button" class="btn btn-sm p-0" data-toggle="dropdown" style="background-color: transparent;"> <i class="mdi mdi-dots-horizontal" style="font-size: 30px"></i></button>
			                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton2">
			                      <a class="dropdown-item" href="{{route('system.application.show',[$application->id])}}">View Application</a>
			                      <a class="dropdown-item action-delete"  data-url="{{route('system.application.destroy',[$application->id])}}" data-toggle="modal" data-target="#confirm-delete">Remove Record</a>
			                    </div>
			                </td>
						@empty
	
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div> -->
</div>
@stop 

@section('page-styles')
<link rel="stylesheet" href="{{asset('system/vendors/c3/c3.min.css')}}">
<link rel="stylesheet" href="{{asset('system/vendors/morris.js/morris.css')}}">
<style type="text/css">
	
.chart-legend li span{
    display: inline-block;
    width: 20px;
    height: 20px;
    margin-right: 5px;
    vertical-align: middle;
  	
}
.chart-legend ul{
	list-style: none;
}
.chart-legend li{
	padding: 5px;
}
.chart-legend{
	  padding-top: 7em;
}
</style>
@stop

@section('page-scripts')
<script src="{{asset('system/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{asset('system/vendors/morris.js/morris.min.js')}}"></script>
<script src="{{asset('system/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('system/vendors/chart.js/chart-js-plugins-labels.js')}}"></script>
<script src="{{asset('system/vendors/d3/d3.min.js')}}"></script>
<script src="{{asset('system/vendors/c3/c3.js')}}"></script>
<script src="{{asset('system/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('system/vendors/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{asset('system/vendors/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('system/vendors/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('system/js/jquery.flot.dashes.js')}}"></script>
<script type="text/javascript">
	Morris.Bar({
		element: 'bar-example',
		data: {!! $per_month_application !!},
		xkey: 'month',
  		ykeys: ['approved', 'declined'],
		labels: ['Approved', 'declined'],
		barColors: ["#0045A2", "#D63231"],
		stacked: true,
		hideHover:'auto',
	});

	var ctx = document.getElementById('myChart').getContext('2d');
	var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Approved', 'Disapproved', 'Pending'],
        datasets: [{
            data: {!! $chart_data !!},
            backgroundColor: ['#2F9A2A', '#D63231', '#F2B33D'],
            borderWidth: 0.5 ,
            borderColor: '#ddd'
        }]
    },
    options: {
    	responsive: true,
       	legend: {
            display: false,
            position: 'right',
            labels: {
                boxWidth: 30,
                fontColor: '#111',
                padding: 30
            },
        },
        tooltips: {
            enabled: false
        },
        plugins:{
			labels: {
				render: 'value',
				fontColor: '#fff',
				fontSize:25
				
			}
		}
    }
});
document.getElementById('js-legend').innerHTML = myChart.generateLegend();
</script>
@stop