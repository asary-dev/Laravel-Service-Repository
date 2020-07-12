<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\ProductService;
use App\Services\OrderService;

use App\Http\Requests\Order\CreateOrder;

class HomeController extends Controller
{

    protected $orderService;
    protected $productService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ProductService $productService,OrderService $orderService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
    }

    
    /**
     * Show the application dashboard.
     */
    public function admin()
    {
        return view('admin.home');
    }
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        
        try {
            $result = $this->productService->getAllProductsWithFormattedPrices();

            // return to view with data
            return view('web.home')->with(["products"=>$result]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

    
    /**
     * Show the application dashboard.
     */
    public function product(Int $id)
    {
        try {
            $result = $this->productService->getOneByIdWithFormattedPrices($id);

            // return to view with data
            return view('web.product')->with(["product"=>$result]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function purchase(Createorder $request)
    {
        try {
            $result = $this->orderService->saveOrder($request);

            return redirect(route('order',$result->id))->with([
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
     * Store a newly created resource in storage.
     */
    public function order(Int $id)
    {
        try {
            $result = $this->orderService->getOneByIdWithFormattedPrices($id);
            return view('web.order')->with(["order"=>$result]);
        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }

}
