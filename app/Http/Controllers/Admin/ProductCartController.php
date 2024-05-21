<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCart;
use App\Models\ProductList;

class ProductCartController extends Controller
{
    public function addtoCart(Request $request)
    {
        $email = $request->input('email');
        $size = $request->input('size');
        $color = $request->input('color');
        $quantity = $request->input('quantity');
        $product_code = $request->input('product_code');

        $product_details = ProductList::where('product_code', $product_code)->get();

        $price = $product_details[0]['price'];
        $special_price = $product_details[0]['special_price'];

        if ($special_price == "na") {
            $total_price = $price * $quantity;
            $unit_price = $price;
        } else {
            $total_price = $special_price * $quantity;
            $unit_price = $special_price;
        }

        $result = ProductCart::insert([
            'email' => $email,
            'image' => $product_details[0]['image'],
            'product_name' => $product_details[0]['title'],
            'product_code' => $product_details[0]['product_code'],
            'size' => "Size: " . $size,
            'color' => "Color: " . $color,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'total_price' => $total_price
        ]);

        return $result;
    }

    public function cartCount(Request $request)
    {
        $email = $request->email;
        $result = ProductCart::where('email', $email)->count();
        return $result;
    }

    public function getCartByEmail(Request $request)
    {
        $email = $request->email;
        $result = ProductCart::where('email', $email)->get();
        return $result;
    }

    public function removeCartById(Request $request)
    {
        $id = $request->id;
        $result = ProductCart::where('id', $id)->delete();
        return $result;
    }

    public function plusItemCart(Request $request)
    {
        $id = $request->id;
        $item = ProductCart::where('id', $id)->get();
        $quantity = $item[0]['quantity'];
        $price = $item[0]['unit_price'];
        $newQuantity = $quantity + 1;
        $total_price = $newQuantity * $price;

        $result = ProductCart::where('id', $id)->update(['quantity' => $newQuantity, 'total_price' => $total_price]);
        return $result;
    }

    public function minusItemCart(Request $request)
    {
        $id = $request->id;
        $item = ProductCart::where('id', $id)->get();
        $quantity = $item[0]['quantity'];
        $price = $item[0]['unit_price'];
        $newQuantity = $quantity - 1;
        $total_price = $newQuantity * $price;

        $result = ProductCart::where('id', $id)->update(['quantity' => $newQuantity, 'total_price' => $total_price]);

        return $result;
    }

    public function cartOrder(Request $request)
    {
    }
}
