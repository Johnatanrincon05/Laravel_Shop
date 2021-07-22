@extends('layouts.app')

@section('template_title')
    Create Order
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="container">
                        <div class="card card-default">
                            <div class="card-header">
                                <span class="card-title">Create Order</span>
                            </div>
                            <div class="card-body">
                                <p>Please fill in the fields with your personal data to proceed with the purchase</p>
                                <form method="POST" action="{{ route('orders.store') }}" role="form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="box box-info padding-1">
                                        <div class="box-body">
                                            <div class="form-group">
                                                {{ Form::label('customer_identification_type') }}
                                                {{Form::select('customer_identification_type', array('CC' => 'Cédula de ciudadanía', 'TI' => 'Tarjeta de identidad'), 'CC');}}
                                                {!! $errors->first('customer_identification', '<div class="invalid-feedback">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('customer_identification') }}
                                                {{ Form::number('customer_identification', $order->customer_identification, ['class' => 'form-control' . ($errors->has('customer_identification') ? ' is-invalid' : ''), 'placeholder' => '123456789']) }}
                                                {!! $errors->first('customer_identification', '<div class="invalid-feedback">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('customer_name') }}
                                                {{ Form::text('customer_name', $order->customer_name, ['class' => 'form-control' . ($errors->has('customer_name') ? ' is-invalid' : ''), 'placeholder' => 'Jhon ortiz']) }}
                                                {!! $errors->first('customer_name', '<div class="invalid-feedback">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('customer_email') }}
                                                {{ Form::text('customer_email', $order->customer_email, ['class' => 'form-control' . ($errors->has('customer_email') ? ' is-invalid' : ''), 'placeholder' => 'Jhondoe@mail.com']) }}
                                                {!! $errors->first('customer_email', '<div class="invalid-feedback">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                {{ Form::label('customer_mobile') }}
                                                {{ Form::number('customer_mobile', $order->customer_mobile, ['class' => 'form-control' . ($errors->has('customer_mobile') ? ' is-invalid' : ''), 'placeholder' => '3123456789']) }}
                                                {!! $errors->first('customer_mobile', '<div class="invalid-feedback">:message</p>') !!}
                                            </div>
                                        </div>
                                        <div class="box-footer mt20">
                                            <button type="submit" class="btn btn-success">Continue</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
