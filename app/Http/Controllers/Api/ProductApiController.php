<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Symfony\Component\HttpFoundation\Response;


class ProductApiController extends Controller
{
     public function index()
    {
        try {
            $products = Product::with('images')->get();

            return response()->json([
                'status' => true,
                'message' => 'Product list fetched successfully',
                'data' => $products
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
