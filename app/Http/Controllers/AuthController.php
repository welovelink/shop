<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\AuthServices;
class AuthController extends Controller
{
    public function index(Request $request){
        $authService = new AuthServices();
        $output = $authService->login($request);
        return response()->json($output->response, $output->httpStatus);
    }
}
