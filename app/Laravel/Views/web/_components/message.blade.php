@extends('frontend.layouts.auth')

@section('title')
Confirmation
@endsection

@push('styles')

@endpush

@section('content')
{{-- Success Message --}}
@if(($prefix == "APP" AND $transaction->application_transaction_status == "COMPLETED") || ($prefix == "PF" AND $transaction->transaction_status == "COMPLETED"))
<div class="flex flex-col justify-center items-center h-screen">
    <div>
        <span class="text-6xl">
            <i class="fas fa-check-circle text-green-600"></i>
        </span> 
    </div>
    <h1 class="font-bold text-4xl text-green-600">Success!</h1>
    <p class="text-gray-payment text-xl font-semibold">Transaction Success</p>
    <p class="text-gray-payment font-medium mt-10 px-5 text-center">
        Your payment has been processed. This is to confirm your Online Application was successful.
    </p>
    <div class="flex flex-col items-center justify-center bg-white w-3/4 lg:w-1/4 px-8 py-12 rounded-lg">
        <a href="{{ route('frontend.index') }}" class="w-full px-8 py-2 bg-blue hover:bg-blue-800 text-white rounded-lg flex flex-row items-center justify-center">
            <p class="pl-1 font-semibold">Go back to home</p>
        </a>
    </div>
</div>
@elseif(($prefix == "APP" AND $transaction->application_transaction_status == "PENDING") || ($prefix == "PF" AND $transaction->transaction_status == "PENDING"))
<div class="flex flex-col justify-center items-center h-screen">
    <div>
        <span class="text-6xl">
            <i class="fas fa-check-circle text-yellow-600"></i>
        </span> 
    </div>
    <h1 class="font-bold text-4xl text-yellow-600">Pending!</h1>
    <p class="text-gray-payment text-xl font-semibold">Transaction Pending</p>
    <p class="text-gray-payment font-medium mt-10 px-5 text-center">
        Sorry your payment was not processed. 
    </p>
    <div class="flex flex-col items-center justify-center bg-white w-3/4 lg:w-1/4 px-8 py-12 rounded-lg">
        <a href="{{ route('frontend.index') }}" class="w-full px-8 py-2 bg-blue hover:bg-blue-800 text-white rounded-lg flex flex-row items-center justify-center">
            <p class="pl-1 font-semibold">Go back to home</p>
        </a>
    </div>
</div>
@else
{{-- Failed Message --}}
<div class="flex flex-col justify-center items-center h-screen">
    <span class="text-6xl">
        <i class="fas fa-times-circle text-red"></i>
    </span> 
    <h1 class="font-bold text-4xl text-red">Failed!</h1>
    <p class="text-gray-payment text-xl font-semibold">Transaction Failed</p>
    <p class="text-gray-payment font-medium mt-10 px-5 text-center">Sorry your card transaction cannot be processed. Please try again, or you may contact your Bank. Thank you.</p>
    <div class="flex flex-col items-center justify-center bg-white w-3/4 lg:w-1/4 px-8 py-12 rounded-lg">
        <a href="{{ route('frontend.index') }}" class="w-full px-8 py-2 bg-blue hover:bg-blue-800 text-white rounded-lg flex flex-row items-center justify-center">
            <p class="pl-1 font-semibold">Go back to home</p>
        </a>
    </div>
</div>
@endif
@endsection

