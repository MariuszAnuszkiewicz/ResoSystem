<?php

namespace ResoSystem\classes;

use ResoSystem\Book;
use ResoSystem\Movie;
use ResoSystem\Music;
use Illuminate\Foundation\Application;
use ResoSystem\Traits\GetPictureTrait;

class CartShopping
{
    use GetPictureTrait;

    protected $appResoSystem;

    public function __construct(Application $app)
    {
        $this->appResoSystem = $app;
    }

    public function addItem($request, $multipleDir, $toComeUrl)
    {
        $id = (int)$request->route('id');
        $name = (string)$request->route('name');
        $joinKey = $id . '/' . $name;

        if (preg_match("/books/", $toComeUrl)) {
            $product = Book::find($id);
        }
        if (preg_match("/movies/", $toComeUrl)) {
            $product = Movie::find($id);
        }
        if (preg_match("/musics/", $toComeUrl)) {
            $product = Music::find($id);
        }
        $class = get_class($product);
        $entry = lcfirst(substr($class, strlen('ResoSystem\\'), strlen($class)));

        if (preg_match("/{$entry}/", $toComeUrl)) {
            if (!$product) {
                abort(404);
            }
            $image = $this->getPictureById($request, $product->name, $multipleDir);
            $cart = session()->get('cart');

            if (!$cart) {
                $cart = [
                    $joinKey => [
                        "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "image" => $image['image']
                    ]
                ];
                session()->put('cart', $cart);
                return redirect()->back()->with('success_add_to_card', 'Product added to cart successfully!');
            }

            if (isset($cart[$joinKey])) {
                $cart[$joinKey]['quantity']++;
                session()->put('cart', $cart);
                return redirect()->back()->with('success_add_to_card', 'Product added to cart successfully!');
            }
            $cart[$joinKey] = [
                "id" => $product->id,
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $image['image']
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success_add_to_card', 'Product added to cart successfully!');
        }
    }

    public function getSession($request)
    {
        return $request->session()->get('cart');
    }

    public function deleteCart($request)
    {
        return $request->session()->forget('cart');
    }

    public function getQuantityProducts()
    {
        $totalQuantity = null;
        if (!empty(session('cart'))) {
            $totalQuantity = 1;
            foreach (session('cart') as $id => $details) {
                $totalQuantity += $details['quantity'];
            }
        }
        return $totalQuantity;
    }

    public function getProducts($type)
    {
        switch ($type) {
            case 'name':
                $product = null;
                if (!empty(session('cart'))) {
                    foreach (session('cart') as $id => $details) {
                        $product[] = $details['name'];
                    }
                }
                return $product;
            case 'price':
                $price = null;
                if (!empty(session('cart'))) {
                    foreach (session('cart') as $id => $details) {
                        $price[] = $details['price'];
                    }
                }
                return $price;
            case 'quantity':
                $quantity = null;
                if (!empty(session('cart'))) {
                    foreach (session('cart') as $id => $details) {
                        $quantity[] = $details['quantity'];
                    }
                }
                return $quantity;
            case 'image':
                $image = null;
                if (!empty(session('cart'))) {
                    foreach (session('cart') as $id => $details) {
                        $image[] = $details['image'];
                    }
                }
                return $image;
        }
    }
}