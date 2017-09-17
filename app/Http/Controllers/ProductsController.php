<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
    	$products = Products::all();

    	return view('products.view', [
    			'products' => $products
    		]);
    }

    public function addProducts(){
    	return view('products.create');
    }

    public function createProducts(Request $request){
    	$input = $request->all();
    	$products = new Products;

    	$validator = Validator::make($input,[
    			'name' => 'required|unique:products',
    			'retailers_price' => 'required',
    			'members_price' => 'required',
    			'resellers_price' => 'required'
    		]);

    	if($validator->fails()){
    		return redirect('/products/addProduct')
    				->withErrors($validator)
    				->withInput();
    	}

    	$products->name = $input['name'];
    	$products->retailers_price = $input['retailers_price'];
    	$products->members_price = $input['members_price'];
    	$products->resellers_price = $input['resellers_price'];

    	$products->save();

    	return redirect('/products/addProduct')
    			->with('success', 'New Products added!');


    }
}