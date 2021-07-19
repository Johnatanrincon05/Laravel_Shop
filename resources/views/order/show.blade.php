@extends('layouts.app')

@section('template_title')
    {{ $order->name ?? 'Show Order' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show order summary</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <form method="POST" action="{{ route('orders.store') }}" role="form" --}}
                                {{-- enctype="multipart/form-data"> --}}
                                <div class="container">
                                    <h2>Graphic card gaming NVIDIA 3090</h2>
                                    <img height="400" width="400" src="{{ URL::to('/') }}/images/PRODUCT1.png" alt="">
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
                                    {{-- <div class="form-group">
                                            <strong>Status:</strong>
                                            {{ $order->status }}
                                        </div> --}}
                                    <div class="d-flex justify-content-end btn-group">
                                        <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a>
                                        <a class="btn btn-success" href="{{ route('payment.create',$order->id) }}"> Pay</a>
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-md-2"></div>
        </div>
    </section>
@endsection
