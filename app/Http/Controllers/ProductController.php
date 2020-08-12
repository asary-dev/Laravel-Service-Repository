<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

use App\Http\Requests\Product\CreateProduct;
use App\Http\Requests\Product\UpdateProduct;


class ProductController extends Controller
{
    
    protected $productService;


    /**
     * Create a new controller instance.
     */
    public function __construct(ProductService $productService)
    {
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
            return Datatables::of($this->productService->getAllProductsWithFormattedPrices($request))
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn =  "<a href='/admin/product/$row->id' class=''>Edit</a> |
                                    <a href='#' onclick='deleteProduct(".$row->id.")' class=''>Delete</a>
                                    ";
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // Return the view
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProduct $request)
    {
        try {
            $result = $this->productService->saveProduct($request);

            return redirect(route('admin.product.index'))->with([
                'status'=>"success",
                "message" => 'Product successully created'
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
    public function show(Int $product)
    {
        try {
            $result = $this->productService->getOneById($product);

            // return to view with data
            return view('admin.product.edit')->with(["product"=>$result]);

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
        return redirect(route('admin.product.show',$user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProduct $request, Int $user)
    { 
        try {
            $result = $this->productService->updateProduct($request, $user);

            return back()->with([
                'status'=>"success",
                "message" => 'Product successully updated.'
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
    public function destroy(Int $product)
    {
        
        try {
            $result = $this->productService->softDeleteProduct($product);

            return redirect(route('admin.product.index'))->with([
                'status'=>"warning",
                "message" => 'Product successully deleted.'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'status'=>"danger",
                "message" => $e->getMessage()
            ]);
        }
    }
}
