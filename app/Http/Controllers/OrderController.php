<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Order;
use Illuminate\Http\Request;

use App\Services\OrderService;
use App\Services\ProductService;

use App\Http\Requests\Order\CreateOrder;
use App\Http\Requests\Order\UpdateOrder;


class OrderController extends Controller
{
    
    protected $orderService;
    protected $productService;


    /**
     * Create a new controller instance.
     */
    public function __construct(OrderService $orderService,ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        // For Datatables
        if ($request->ajax()) {
            return Datatables::of($this->orderService->getAllOrdersWithFormattedPrices())
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn =  "<a href='/admin/order/$row->id' class=''>Edit</a> |
                                    <a href='#' onclick='deleteOrder(".$row->id.")' class=''>Delete</a>
                                    ";
                            return $btn;
                    })
                    ->addColumn('product_detail', function($row) {
                        return '<a href="/admin/product/'.$row->product_detail->id.'"> ' . $row->product_detail->product_code." - ". $row->product_detail->product_name . '!';
                    })
                    ->rawColumns(['action','product_detail'])
                    ->make(true);
        }

        // Return the view
        return view('admin.order.index');
    }

    /**
     * 
     * Endpoint for select Product
     * 
     */
    public function selectProduct(){
        
        try {
            return response()->json($this->productService->getAllProductsWithFormattedPrices(),200);
        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Createorder $request)
    {
        try {
            $result = $this->orderService->saveOrder($request);

            return redirect(route('admin.order.index'))->with([
                'status'=>"success",
                "message" => 'order successully created'
            ]);
        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Int $order)
    {
        try {
            $result = $this->orderService->getOneByIdWithFormattedPrices($order);

            // return to view with data
            return view('admin.order.edit')->with(["order"=>$result]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Int $user)
    {
        return redirect(route('admin.order.show',$user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateorder $request, Int $user)
    { 
        try {
            $result = $this->orderService->updateOrder($request, $user);

            return back()->with([
                'status'=>"success",
                "message" => 'order successully updated.'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Int $order)
    {
        
        try {
            $result = $this->orderService->softDeleteOrder($order);

            return redirect(route('admin.order.index'))->with([
                'status'=>"warning",
                "message" => 'order successully deleted.'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }
}
