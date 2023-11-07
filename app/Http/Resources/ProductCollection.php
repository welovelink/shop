<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
class ProductCollection extends ResourceCollection
{
    public function __construct()
    {

    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return Product::with('category')->paginate(50)->through(function($product){
            $product->category_name = $product->category->name;
            unset($product->category);
            return $product;
        });
    }
}
