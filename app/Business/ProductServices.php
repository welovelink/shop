<?php
namespace App\Business;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
class ProductServices{


    public function __construct()
    {

    }

    public function getProduct(Request $request)
    {
        return new ProductCollection();
    }

    public function getProductPaginate(Request $request)
    {
        $page = ($request->get('page')) ? $request->get('page') : 1;
        $cacheKey = 'product_page' . $page;
        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
            return [
                'message' => 'Fetched from cache',
                'result' => $result,
            ];
        } else {
            $result = new ProductCollection();
            Cache::put($cacheKey, $result, 300);
            return [
                'message' => 'Fetched from database',
                'result' => $result,
            ];
        }
    }

    public function UpdateProduct(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return (object)[
                'body' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST
            ];
        }

        try{
            $id = $request->route('id');
            $product = Product::where('id', $id)->first();
            $product->name = $request->post('name');
            $product->price = $request->post('price');
            $product->category_id = $request->post('category_id');
            $product->updated_at = now();
            $product->save();
            return (object)[
                'body' => [
                    'status' => 'ok',
                    'id' => $product->id,
                    'product' => $product
                ],
                'status' => Response::HTTP_OK
            ];
        }
        catch(\Exception $e){
            Log::error($request->get('q') . ' ' . $e->getMessage());
            return (object)[
                'body' => $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }


    }
}
