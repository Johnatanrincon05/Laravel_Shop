@extends('layouts.app')

@section('template_title')
    {{ $order->name ?? 'Show Order' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Order</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
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
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $order->status }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
