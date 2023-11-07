<?php

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MproductController;
use App\Models\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Events\UserCreated;
use App\Events\ProductUpdated;
use Illuminate\Support\Facades\Cache;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['request.log', 'api_key']], function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['middleware' => ['allow.backend']], function () {
            Route::prefix('manage')->group(function () {
                Route::prefix('product')->group(function () {
                    Route::get('/', [MproductController::class, 'index']);
                    Route::get('/create', [MproductController::class, 'create']);
                    Route::put('/update/{id}', [MproductController::class, 'update']);
                });
            });
        });


        Route::get('/product', [ProductController::class, 'index']);
        Route::post('/order', [OrderController::class, 'store'])->name('created-order');
    });

    Route::get('/login', function () {
        abort(401);
    })->name('login');

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{id}', [OrderController::class, 'show']);

    Route::put('orders/{id}', [OrderController::class, 'update']);
    Route::delete('orders/{id}', [OrderController::class, 'delete']);

    Route::get('/bcrypt', function () {
        return response()->json([
            'password' => bcrypt('12345')
        ]);
    });

    Route::get('/redis', function () {
        //$cached = Redis::get('test_redis');
        $cached = Cache::get('test_redis');
        if (Cache::has('test_redis')) {
            $test_redis = json_decode($cached, FALSE);

            return response()->json([
                'status_code' => 201,
                'message' => 'Fetched from redis',
                'data' => $test_redis,
            ]);
        } else {
            $data = ['name' => 'sakda'];
            //Redis::set('test_redis', json_encode($data));
            Cache::put('test_redis', json_encode($data), 300);

            return response()->json([
                'status_code' => 201,
                'message' => 'Fetched from database',
                'data' => $data,
            ]);
        }
    });

    Route::post('/login', [AuthController::class, 'index']);

    /*Route::post('/login', function (Request $request) {
        $credentials = $request->only(['email', 'password']);
        if (!auth()->validate($credentials)) {
            abort(401);
        } else {
            $user = User::where('email', $credentials['email'])->first();
            $user->tokens()->delete();
            $token = $user->createToken($request->server('HTTP_USER_AGENT'), ['admin']);
            return response()->json(['status' => 'ok', 'accessToken' => $token->plainTextToken]);
        }
    });*/

    Route::get('/mail', function () {
        /*Helper::EmailSend([
            'name' => 'Sakda',
            'email' => 'welovelink@gmail.com',
            'subject' => 'Test',
            'message' => '<b>Message</b>',
        ]);*/
        event(new UserCreated('abc@gmail.com'));
    });

    Route::get('/test-product', function () {
        event(new ProductUpdated());
    });
});

