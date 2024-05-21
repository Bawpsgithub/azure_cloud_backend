<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeSliderController extends Controller
{
    public function getAllHomeSlider()
    {
        try {
            $home_slider = HomeSlider::all();
            $count = count($home_slider);

            $data = [
                'message' => "Get total {$count} slider successfully",
                'data' => $home_slider
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
}
