<?php

namespace App\Http\Controllers;

use App\Products_table;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    function index(Request $request)
    {
        if ($request->isJson()) {
            $products = Products_table::all();

            return response()->json($products, 200);
        } else {
            return response()->json(['error' => 'no autorizado'], 401,[]);
        }



    }

    function createProduct(Request $request) {

        if ($request->isJson()) {
            $create_data = $request->json()->all();


            $create_product = Products_table::create([
                "name_product" => $create_data["name_product"],
                "sku" => $create_data["sku"],
                "description" => $create_data["description"],
                "api_token" => $create_data["api_token"]
            ]);

            return response()->json($create_product, 201);
        } else {
            return response()->json(['error' => 'no autorizado'], 401,[]);
        }

    }

}
