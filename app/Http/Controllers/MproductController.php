<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\ProductServices;

class MproductController extends Controller
{
    private ProductServices $productServices;

    public function __construct(ProductServices $productServices)
    {
        $this->productServices = $productServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json($this->productServices->getProduct($request));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $return = $this->productServices->UpdateProduct($request);
        return response()->json($return->body, $return->status);
    }
}
