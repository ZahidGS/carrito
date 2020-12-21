<?php

namespace App\Http\Controllers;

use App\Services\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();

        //return $products;
        return view('products.index', compact('products'));
    }

    public function showCart() {
        return view("cart.cart");
    }

    public function addProductToCart(Product $product) {
        $cart = new Cart;
        $cart->addProduct($product);
        session()->flash("message", ["success", "Producto añadido al carrito correctamente"]);
        return redirect(route('cart'));
    }

    public function removeProductFromCart(Product $product) {
        $cart = new Cart;
        $cart->removeProduct($product->id);
        session()->flash("message", ["success", __("Curso eliminado del carrito correctamente")]);
        return back();
    }

    public function orders()
    {
        $orders = auth()->user()->processedOrders();
        $suma = 0;
        return view('products.orders', compact('orders', 'suma'));
    }

}
