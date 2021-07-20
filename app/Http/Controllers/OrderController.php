<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate();

        return view('order.index', compact('orders'))->with('i', (request()->input('page', 1) - 1) * $orders->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = new Order();
        
        return view('order.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Order::$rules);

        $request->request->add(['order_reference' => $this->generateOrderId()]);
        $request->request->add(['status' => 'CREATED']);
        $request->request->add(['total' => '250000']);
        $request->request->add(['product' => 'Graphic card gaming NVIDIA 3090']);

        $order = Order::create($request->all());

        return redirect()->route('orders.show',$order->id)->with('success', 'Order created successfully.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        $transactions = Order::find($id)->transactions;

        $pending_transactions_count = 0;

        foreach($transactions as $transaction){

            if ($transaction->status == "PENDING") {
                $pending_transactions_count++;
            }

        }

        return view('order.show', compact('order','transactions','pending_transactions_count'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);

        return view('order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        request()->validate(Order::$rules);

        $order->update($request->all());

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $order = Order::find($id)->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
    
    public function generateOrderId(){

        do {

            $order_reference_id = "NID".rand(111111,999999);

            $count_order_id = Order::where('order_reference', '=', $order_reference_id)->count();

        } while ($count_order_id != 0);

        return $order_reference_id;

    }

}
