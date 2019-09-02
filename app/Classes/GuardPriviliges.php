<?php
namespace ResoSystem\classes;

use ResoSystem\Client;
use ResoSystem\Book;
use ResoSystem\Movie;
use ResoSystem\Music;

class GuardPriviliges
{
    public function typeClientAccess($request, $id, CartShopping $cartShopping, $toComeUrl)
    {
        $clientPriviliges = Client::find($id)->first();
        if ($clientPriviliges->client_priviliges === 'ADD_ORDER') {
            if ($cartShopping->getQuantityProducts() <= 3) {
                if (preg_match('/books/', $toComeUrl)) {
                    $dirBooks = [Book::PATH_COMPUTER_SCIENCE, Book::PATH_GEOPOLITICS, Book::PATH_LITERATURE];
                    $cartShopping->addItem($request, $dirBooks, $toComeUrl);
                }
                if (preg_match('/movies/', $toComeUrl)) {
                    $dirMovies = [Movie::PATH_MOVIES];
                    $cartShopping->addItem($request, $dirMovies, $toComeUrl);
                }
                if (preg_match('/musics/', $toComeUrl)) {
                    $dirMusics = [Music::PATH_MUSICS];
                    $cartShopping->addItem($request, $dirMusics, $toComeUrl);
                }
            } else {
                //$request->session()->flash('error_priviliges', 'To much quantities products for this type user');
                dd('to much quantities for this type user');
            }
        } else {
            if (preg_match('/books/', $toComeUrl)) {
                $dirBooks = [Book::PATH_COMPUTER_SCIENCE, Book::PATH_GEOPOLITICS, Book::PATH_LITERATURE];
                $cartShopping->addItem($request, $dirBooks, $toComeUrl);
            }
            if (preg_match('/movies/', $toComeUrl)) {
                $dirMovies = [Movie::PATH_MOVIES];
                $cartShopping->addItem($request, $dirMovies, $toComeUrl);
            }
            if (preg_match('/musics/', $toComeUrl)) {
                $dirMusics = [Music::PATH_MUSICS];
                $cartShopping->addItem($request, $dirMusics, $toComeUrl);
            }
        }
    }
}