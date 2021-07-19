@extends('layouts.app')

@section('template_title')
    Products List
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Select your product</span>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('orders.create') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-4 shadow">
                                        <div class="card-header">Graphic card gaming NVIDIA 3090</div>
                                        <img src="{{ URL::to('/') }}/images/PRODUCT1.png" alt="">
                                        <div class="card-body">
                                            <h3>$250.000 COP</h3>
                                            <p class="card-text">This is the most powerful graphics card on the market.</p>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-sm btn-success">Buy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </section>
@endsection
