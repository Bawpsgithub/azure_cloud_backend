<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductListController extends Controller
{
    public function getProductListByRemark(Request $request)
    {
        try {
            $remark = $request->remark;
            $product_list = ProductList::where('remark', $remark)->get();
            $count = count($product_list);
            $data = [
                'message' => "Get total {$count} products by remark successfully",
                'data' => $product_list
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    public function getProductListByCategory(Request $request)
    {
        try {
            $category = $request->category;
            $product_list = ProductList::where('category', $category)->get();
            $count = count($product_list);
            $data = [
                'message' => "Get total {$count} products by category successfully",
                'data' => $product_list
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    public function getProductListBySubCategory(Request $request)
    {
        try {
            $category = $request->category;
            $subcategory = $request->subcategory;
            $product_list = ProductList::where('category', $category)->where('subcategory', $subcategory)->get();
            $count = count($product_list);
            $data = [
                'message' => "Get total {$count} products by sub category successfully",
                'data' => $product_list
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    public function getProductBySearch(Request $request)
    {
        try {
            $key = $request->key;
            $products = ProductList::where('title', 'LIKE', "%{$key}%")->get();

            $response = [
                "message" => "Get product by key successfully",
                'data' => $products
            ];
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());

            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    public function similarProduct(Request $request)
    {
        $subcategory = $request->subcategory;
        $product_list = ProductList::where('subcategory', $subcategory)->orderBy('id', 'desc')->limit(6)->get();
        return $product_list;
    }
}
