@extends('app')

@section('content')
<div class="mt-3">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-comments"></i> WhatsApp Messages</h5>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-up text-success"></i> Sent:</span> 500</p>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-down text-danger"></i> Received:</span> 350</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow border border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-envelope"></i> Emails</h5>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-up text-success"></i> Sent:</span> 1000</p>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-down text-danger"></i> Received:</span> 800</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow border border-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-sms"></i> SMS Messages</h5>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-up text-success"></i> Sent:</span> 300</p>
                    <p class="card-text"><span class="font-weight-bold"><i class="fas fa-arrow-down text-danger"></i> Received:</span> 250</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
