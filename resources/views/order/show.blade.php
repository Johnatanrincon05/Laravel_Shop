@extends('layouts.app')

@section('template_title')
    {{ $order->name ?? 'Show Order' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Order summary</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('danger'))
                            <div class="alert alert-danger">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="alert 
                                    @if($order->status == "PAYED")
                                        alert-success
                                    @elseif($order->status == "CREATED")
                                        alert-warning
                                    @elseif($order->status == "REJECTED")
                                        alert-danger
                                    @endif
                                    ">
                                        <h1> Order {{ $order->status }}</h1>
                                    </div>
                                    <h2>Graphic card gaming NVIDIA 3090</h2>
                                    <img class="img-fluid" height="400" width="400" src="{{ URL::to('/') }}/images/PRODUCT1.png" alt="">
                                    <h3>$250.000 COP</h3>
                                    <p class="card-text">This is the most powerful graphics card on the market.</p>
                                    <div class="form-group">
                                        <strong>Customer Name:</strong>
                                        {{ $order->customer_name }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Customer Email:</strong>
                                        {{ $order->customer_email }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Customer Mobile:</strong>
                                        {{ $order->customer_mobile }}
                                    </div>
                                    <div class="d-flex justify-content-end btn-group">
                                        <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a>

                                        @if($order->status != "PAYED")
                                            <a class="btn btn-success" href="{{ route('payment.create', $order->id) }}">
                                                @if($pending_transactions_count > 0)
                                                    Continue pending payment
                                                @elseif($order->status == "REJECTED")
                                                    Retry payment
                                                @else
                                                    Pay
                                                @endif
                                            </a>                 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-3" style="max-width: 18rem;">
                    <div class="card-header">Order payment history</div>
                    <div class="card-body">
                        <div class="overflow-auto">

                            @foreach ($transactions as $transaction)
                                <div class="card @if($transaction->status == "APPROVED")
                                    border-success
                                @elseif($transaction->status == "PENDING")
                                    border-info
                                @elseif($transaction->status == "REJECTED")
                                    border-danger
                                @endif mb-3" style="max-width: 18rem;">
                                    <div class="card-header">Transaction attemp #{{ $transaction->reference_code }}</div>
                                    <div class="card-body @if($transaction->status == "APPROVED")
                                        text-success
                                    @elseif($transaction->status == "PENDING")
                                    text-info
                                    @elseif($transaction->status == "REJECTED")
                                        text-danger
                                    @endif">
                                        <h5 class="card-title">{{ $transaction->created_at }}</h5>
                                        <p class="card-text">{{ "$ ".number_format($order->total, 2, '.', ','); }}</p>
                                        <p class="card-text">{{ $transaction->status }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        </div>
        </div>
    </section>
@endsection
