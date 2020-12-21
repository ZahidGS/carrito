<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;


/**
 * Class Cart
 * @package App\Classes
 */

 class Cart {

    // permite saber el tipo de datos de nuestra clase
    //define la clase cart como una collection
    protected Collection $cart;

        /**
     * Cart constructor.
     */
    public function __construct() {
        if (session()->has("cart")) {
            $this->cart = session("cart");
        } else {
            $this->cart = new Collection;
        }
    }

    /**
     *
     * Get cart contents
     *
     */
    //podemos acceder al contenido del carrito
    //que tenga un cliente
    public function getContent(): Collection {
        return $this->cart;
    }


    /**
     * Save the cart on session
     */
    //actualizar la informacion cart
    protected function save(): void {
        session()->put("cart", $this->cart);
        session()->save();
    }

    /**
     *
     * Add Product on cart
     *
     * @param Product $product
     */
    //agrega un producto al carrito
    public function addProduct(Product $product): void {
        $this->cart->push($product);
        $this->save();//llama al save del metodo de arriba
    }

    /**
     *
     * Remove Product from cart
     *
     * @param int $id
     */
    public function removeProduct(int $id): void {
        $this->cart = $this->cart->reject(function (Product $product) use ($id) {
            return $product->id === $id;
        });
        $this->save();
    }

    /**
     *
     * calculates the total cost in the cart
     *
     * @param bool $formatted
     * @return mixed
     */
    public function totalAmount() {
        $amount = $this->cart->sum(function (Product $product) {
            return $product->price;
        });

        return $amount;
    }

    /**
     *
     * Total products in cart
     *
     * @return int
     */
    public function hasProducts(): int {
        return $this->cart->count();
    }

    /*
     * Clear cart
     */
    public function clear(): void {
        $this->cart = new Collection;
        $this->save();
    }


 }
