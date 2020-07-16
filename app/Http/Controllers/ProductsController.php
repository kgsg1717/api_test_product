<?php

namespace App\Http\Controllers;
use Validator;
use App\Products_table;
use App\Products_carts_table;
use App\Carts_table;
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
        $response = array();

        if ($request->isJson()) {
            $create_data = $request->json()->all();



                $validator = Validator::make($request->all(), [
                    'name_product' => 'required',
                    'sku' => 'required',
                    'description' => 'required',
                    'price' => 'required',
                ]);



                if ($validator->fails()) {
                    $error_validate=$validator->errors()->all();
                    $response = array(
                        'status' => 'warning',
                        'message' =>  $error_validate

                      );


                 return response()->json($response, 401);

                 } else {


                    $create_product = Products_table::create([
                        "name_product" => $create_data["name_product"],
                        "sku" => $create_data["sku"],
                        "description" => $create_data["description"],
                        "price" => $create_data["price"]
                    ]);


                    $response = array(
                        'status' => 'success',
                        'message' => "El producto ".$create_data["name_product"]." fue creado satisfactoriamente "
                      );

                    return response()->json($response, 200);


                 }




        } else {
            $response = array(
                'status' => 'danger',
                'message' => 'error al crear el producto "contacte con soporte"'
              );


            return response()->json( $response);
        }

    }



    function updateProduct(Request $request) {
        $response = array();

        if ($request->isJson()) {
            $update_product = $request->json()->all();



                $validator = Validator::make($request->all(), [
                    'name_product' => 'required',
                    'sku' => 'required',
                    'description' => 'required',
                    'price' => 'required',
                ]);



                if ($validator->fails()) {
                    $error_validate=$validator->errors()->all();
                    $response = array(
                        'status' => 'warning',
                        'message' =>  $error_validate

                      );


                 return response()->json($response, 401);

                 } else {

                    $product_db = Products_table::find($update_product["id"]);

                    $product_db->name_product= $update_product["name_product"];
                    $product_db->sku= $update_product["sku"];
                    $product_db->description = $update_product["description"];
                    $product_db->price=$update_product["price"];
                    $product_db->save();


                    $response = array(
                        'status' => 'success',
                        'message' => "El producto ".$update_product["name_product"]." fue creado satisfactoriamente "
                      );

                    return response()->json($response, 200);


                 }




        } else {
            $response = array(
                'status' => 'danger',
                'message' => 'error al crear el producto "contacte con soporte"'
              );


            return response()->json( $response);
        }

    }





    function index_carrito(Request $request)
    {
        $response_product_in_cart=[];

        if (Carts_table::where('id', '=', $request->product_id_in_cart )->exists()) {

            if (Products_carts_table::where('id', '=', $request["product_id_numbers"] )->exists()){

                    $product_db_table = Products_carts_table::find($request["product_id_numbers"]);
                    $product_db_table->product_id= $request["id"];
                    $product_db_table->cart_id= $request["product_id_in_cart"];
                    $product_db_table->quantity = $request["numbers"];
                    $product_db_table->save();

                    $response_product_in_cart=[
                        "id"=> $request["id"],
                        "name_product"=>  $request["name_product"],
                        "inCart"=>  $request["inCart"],
                        "sku"=> $request["sku"],
                        "description"=>  $request["description"],
                        "price"=>  $request["price"],
                        "numbers"=> $request["numbers"],
                        "product_id_in_cart"=> $request["product_id_in_cart"],
                        "product_id_numbers"=> $product_db_table["id"],

                    ];

            }else{
                $create_product_cart_02 = Products_carts_table::create([
                    "product_id" => $request["id"],
                    "cart_id" => $request["product_id_in_cart"],
                    "quantity" =>  $request["numbers"],

                ]);

                $response_product_in_cart=[
                    "id"=> $request["id"],
                    "name_product"=>  $request["name_product"],
                    "inCart"=>  $request["inCart"],
                    "sku"=> $request["sku"],
                    "description"=>  $request["description"],
                    "price"=>  $request["price"],
                    "numbers"=> $request["numbers"],
                    "product_id_in_cart"=>  $request["product_id_in_cart"],
                    "product_id_numbers"=> $create_product_cart_02["id"],

                ];

            }
         }else {
            $create_status_cart = Carts_table::create([
                "status" => "pending",

            ]);

            $create_product_cart = Products_carts_table::create([
                "product_id" => $request["id"],
                "cart_id" => $create_status_cart["id"],
                "quantity" =>  $request["numbers"],

            ]);

            $response_product_in_cart=[
                "id"=> $request["id"],
                "name_product"=>  $request["name_product"],
                "inCart"=>  $request["inCart"],
                "sku"=> $request["sku"],
                "description"=>  $request["description"],
                "price"=>  $request["price"],
                "numbers"=> $request["numbers"],
                "product_id_in_cart"=>  $create_status_cart["id"],
                "product_id_numbers"=> $create_product_cart["id"],

            ];


         }

            return response()->json( $response_product_in_cart );




    }


    function CheckOutForm(Request $request){

        $cart = Carts_table::where('status', '=', 'pending')->find($request["id"]);
        $cart_data="";
        $foreach_product=$request["products"];
        if (!empty($cart)) {
            $cart->status= "completed";
            $cart->save();

            foreach($foreach_product as $row){
                $cart_data = Products_carts_table::find($row['product_id_numbers']);
                $cart_data->product_id = $row['id'];
                $cart_data->cart_id = $cart['id'];
                $cart_data->quantity = $row['numbers'];
                $cart_data->save();
            }




        }else{
            $cart_data="vacio";
        }


        return response()->json( $request["products"][1]['product_id_numbers'] );

    }



}
