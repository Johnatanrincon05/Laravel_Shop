@extends('layouts.app')

@section('template_title')
    Your Orders
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Your Orders') }}
                            </span>

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
										<th>Order Id</th>
										<th>Customer Name</th>
										<th>Customer Email</th>
										<th>Customer Mobile</th>
										<th>Order Date</th>
										<th>Product</th>
										<th>Total</th>
										<th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $order->order_reference }}</td>
											<td>{{ $order->customer_name }}</td>
											<td>{{ $order->customer_email }}</td>
											<td>{{ $order->customer_mobile }}</td>
                                            <td>{{ $order->created_at }}</td>
											<td>{{ $order->product }}</td>
											<td>{{ "$ ".number_format($order->total, 2, '.', ',') }}</td>

											<td class="
                                            @if($order->status == 'PAYED')
                                                table-success
                                            @elseif($order->status == 'REJECTED')
                                                table-danger
                                            @else
                                                table-warning
                                            @endif ">{{ $order->status }}</td>
                                            

                                            <td>
                                                <a class="btn btn-sm btn-primary " href="{{ route('orders.show',$order->id) }}"><i class="fa fa-fw fa-eye"></i> Details</a>
                                                @csrf
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $orders->links() !!}
            </div>
        </div>
    </div>
@endsection
