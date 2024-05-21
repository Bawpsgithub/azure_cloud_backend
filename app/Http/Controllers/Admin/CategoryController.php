<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function getAllCategory(){
        try{
            $data = Category::all();
            $reponse = [
                "message" => "Get all category successfully",
                "data" => $data
            ];
            return response()->json($reponse);
        }catch(\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
        }//end method
    
    public function getCategoryByGroup(){
        try{
            $categories = Category::all();
            $categoryDetailsArray = [];
            
            foreach($categories as $category){
                $subcategory = Subcategory::where('category_name',$category['category_name'])->get();
                $data = [
                    'category_name' => $category['category_name'],
                    'category_image' => $category['category_image'],
                    'subcategory_name' => $subcategory
                ];
    
                array_push($categoryDetailsArray, $data);
            }

          
            return response()->json($categoryDetailsArray);
        }catch(\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }
}
