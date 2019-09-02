<?php

namespace ResoSystem\classes;

class DiscountManage
{
    const DISCOUNT_FOR_BOOKS = 15;
    const DISCOUNT_FOR_MOVIES = 10;
    const DISCOUNT_FOR_MUSICS = 10;

    public function calculateDiscount(CartShopping $cartShopping)
    {
        foreach ($cartShopping->getProducts('price') as $product) {
            $products[] = $product;
        }
        foreach ($cartShopping->getProducts('image') as $product) {
            $images[] = $product;
        }

        $sum = array_sum($products);
        $discount = null;
        $methodDiscount = null;
        $percent = null;
        foreach ($images as $key => $value) {
            if (count($images) >= 3) {
                if (preg_match('/book/', $images[$key])) {
                    $discount = self::DISCOUNT_FOR_BOOKS;
                    $divideDiscount = (int) $discount / 100;
                    $percent = $divideDiscount * $sum;
                    $methodDiscount = $sum - $percent;
                }
                if (preg_match('/movie/', $images[$key])) {
                    $discount = self::DISCOUNT_FOR_MOVIES;
                    $divideDiscount = (int) $discount / 100;
                    $percent = $divideDiscount * $sum;
                    $methodDiscount = $sum - $percent;
                }
                if (preg_match('/music/', $images[$key])) {
                    $discount = self::DISCOUNT_FOR_MUSICS;
                    $methodDiscount = $sum - $discount;
                }
            }
        }
        return $amountWithDiscount = $methodDiscount;
    }
}