<?php

namespace ResoSystem\Http\Controllers;

use Illuminate\Http\Request;
use ResoSystem\classes\DiscountMovies;
use ResoSystem\Client;
use ResoSystem\Book;
use ResoSystem\Movie;
use ResoSystem\Music;
use ResoSystem\Traits\ContentBooksTrait;
use ResoSystem\Traits\ContentMoviesTrait;
use ResoSystem\Traits\ContentMusicsTrait;
use ResoSystem\Traits\LoadDataTablesTrait;
use ResoSystem\Traits\RenameFolderBooksTrait;
use ResoSystem\Traits\RenameFolderMoviesTrait;
use ResoSystem\Traits\RenameFolderMusicsTrait;
use ResoSystem\classes\CartShopping;
use ResoSystem\classes\GuardPriviliges;
use ResoSystem\classes\DiscountManage;
use Auth;

class ResoSystemController extends Controller
{
    use ContentBooksTrait, ContentMoviesTrait, ContentMusicsTrait, LoadDataTablesTrait, RenameFolderBooksTrait, RenameFolderMoviesTrait, RenameFolderMusicsTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function home(Request $request, Client $client, Book $book, Movie $movie, Music $music)
    {
        $id = Auth::id();
        $searchClient = Client::find($id);
        $request->session()->forget('cart');
        $dirBooks = [Book::PATH_COMPUTER_SCIENCE, Book::PATH_GEOPOLITICS, Book::PATH_LITERATURE];
        $dirMovies = [Movie::PATH_MOVIES];
        $dirMusics = [Music::PATH_MUSICS];
        $documentRoot = $request->server('DOCUMENT_ROOT');
        $this->renameContentFolderBooks($documentRoot, public_path(), $dirBooks);
        $this->renameContentFolderMovies($documentRoot, public_path(), $dirMovies);
        $this->renameContentFolderMusics($documentRoot, public_path(), $dirMusics);

        $this->loadTablesFromJson($book, $movie, $music);
        $priviliges = [Client::MANAGE_ORDER, Client::ADD_ORDER];
        if ($searchClient === null) {
            $client->insertToClientTable($id, $priviliges[0]);
        }
        $clientPriviliges = Client::find($id)->first();
        return view('user.home', ['clientPriviliges' => $clientPriviliges]);
    }

    public function books(Request $request, CartShopping $cartShopping, DiscountManage $discountManage)
    {

        $id = Auth::id();
        $documentRoot = $request->server('DOCUMENT_ROOT');
        $dirBooks = [Book::PATH_COMPUTER_SCIENCE, Book::PATH_GEOPOLITICS, Book::PATH_LITERATURE];
        $imagesBooks = [];
        foreach ($this->loadContentAllBooks($documentRoot, $dirBooks, $request) as $key => $imageBook) {
            if ($key == 0) {
                $imagesBooks['images'] = $imageBook;
            }
            if ($key == 1) {
                $imagesBooks['titles'] = $imageBook;
            }
            if ($key == 2) {
                $imagesBooks['books'] = $imageBook;
            }
            if ($key == 3) {
                $imagesBooks['subfolders'] = $imageBook;
            }
        }
        $category = substr(strrchr(url()->current(), "/"), 1, strlen(strrchr(url()->current(), "/")));
        $category = str_replace('_', ' ', $category);
        $category = explode(" ", $category);
        $typeCategory = count($category) > 1 ? ucfirst($category[0]) . " " . ucfirst($category[1]) : ucfirst($category[0]);
        $clientPriviliges = Client::find($id)->first();
        $currentUrl = $request->server('REQUEST_URI');

        if (!empty(session('cart'))) {
            $products = [];
            foreach ($cartShopping->getProducts('price') as $product) {
                $products[] = $product;
            }
            $sum = array_sum($products);
            $quantity = [];
            foreach($cartShopping->getProducts('quantity') as $product) {
                $quantity[] = $product;
            }
            $quantityProducts = array_sum($quantity);
            $totalWithDiscount = $discountManage->calculateDiscount($cartShopping);
            return view('user.books', ['images' => $imagesBooks['images'], 'titles' => $imagesBooks['titles'], 'books' => $imagesBooks['books'], 'subfolders' => $imagesBooks['subfolders'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'sum' => $sum, 'clientPriviliges' => $clientPriviliges, 'totalWithDiscount' => $totalWithDiscount, 'quantityProducts' => $quantityProducts]);
        }
        return view('user.books', ['images' => $imagesBooks['images'], 'titles' => $imagesBooks['titles'], 'books' => $imagesBooks['books'], 'subfolders' => $imagesBooks['subfolders'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'clientPriviliges' => $clientPriviliges]);
    }

    public function movies(Request $request, CartShopping $cartShopping, DiscountManage $discountManage)
    {
        $id = Auth::id();
        $documentRoot = $request->server('DOCUMENT_ROOT');
        $dirMovies = [Movie::PATH_MOVIES];
        $imagesMovies = [];
        foreach ($this->loadContentAllMovies($documentRoot, $dirMovies) as $key => $imageMovie) {

            if ($key == 0) {
                $imagesMovies['images'] = $imageMovie;
            }
            if ($key == 1) {
                $imagesMovies['titles'] = $imageMovie;
            }
            if ($key == 2) {
                $imagesMovies['movies'] = $imageMovie;
            }
        }

        $category = substr(strrchr(url()->current(), "/"), 1, strlen(strrchr(url()->current(), "/")));
        $category = str_replace('_', ' ', $category);
        $category = explode(" ", $category);
        $typeCategory = count($category) > 1 ? ucfirst($category[0]) . " " . ucfirst($category[1]) : ucfirst($category[0]);
        $clientPriviliges = Client::find($id)->first();
        $currentUrl = $request->server('REQUEST_URI');
        if (!empty(session('cart'))) {
            $products = [];
            foreach ($cartShopping->getProducts('price') as $product) {
                $products[] = $product;
            }
            $sum = array_sum($products);
            $quantity = [];
            foreach($cartShopping->getProducts('quantity') as $product) {
                $quantity[] = $product;
            }
            $quantityProducts = array_sum($quantity);
            $totalWithDiscount = $discountManage->calculateDiscount($cartShopping);
            return view('user.movies', ['images' => $imagesMovies['images'], 'titles' => $imagesMovies['titles'], 'movies' => $imagesMovies['movies'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'sum' => $sum, 'clientPriviliges' => $clientPriviliges, 'totalWithDiscount' => $totalWithDiscount, 'quantityProducts' => $quantityProducts]);
        }
        return view('user.movies', ['images' => $imagesMovies['images'], 'titles' => $imagesMovies['titles'], 'movies' => $imagesMovies['movies'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'clientPriviliges' => $clientPriviliges]);
    }

    public function musics(Request $request, CartShopping $cartShopping, DiscountManage $discountManage)
    {
        $id = Auth::id();
        $documentRoot = $request->server('DOCUMENT_ROOT');
        $dirMusics = [Music::PATH_MUSICS];
        $imagesMusics = [];
        foreach ($this->loadContentAllMusics($documentRoot, $dirMusics) as $key => $imageMusic) {

            if ($key == 0) {
                $imagesMusics['images'] = $imageMusic;
            }
            if ($key == 1) {
                $imagesMusics['titles'] = $imageMusic;
            }
            if ($key == 2) {
                $imagesMusics['musics'] = $imageMusic;
            }
        }
        $category = substr(strrchr(url()->current(), "/"), 1, strlen(strrchr(url()->current(), "/")));
        $category = str_replace('_', ' ', $category);
        $category = explode(" ", $category);
        $typeCategory = count($category) > 1 ? ucfirst($category[0]) . " " . ucfirst($category[1]) : ucfirst($category[0]);
        $clientPriviliges = Client::find($id)->first();
        $currentUrl = $request->server('REQUEST_URI');
        if (!empty(session('cart'))) {
            $products = [];
            foreach ($cartShopping->getProducts('price') as $product) {
                $products[] = $product;
            }
            $sum = array_sum($products);
            $quantity = [];
            foreach($cartShopping->getProducts('quantity') as $product) {
                $quantity[] = $product;
            }
            $quantityProducts = array_sum($quantity);
            $totalWithDiscount = $discountManage->calculateDiscount($cartShopping);
            return view('user.musics', ['images' => $imagesMusics['images'], 'titles' => $imagesMusics['titles'], 'musics' => $imagesMusics['musics'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'sum' => $sum, 'clientPriviliges' => $clientPriviliges, 'totalWithDiscount' => $totalWithDiscount, 'quantityProducts' => $quantityProducts]);
        } else {
            return view('user.musics', ['images' => $imagesMusics['images'], 'titles' => $imagesMusics['titles'], 'musics' => $imagesMusics['musics'], 'category' => $typeCategory, 'currentUrl' => $currentUrl, 'clientPriviliges' => $clientPriviliges]);
        }
    }

    public function addToCart(Request $request, CartShopping $cartShopping, GuardPriviliges $guardPriviliges)
    {
        $id = Auth::id();
        $toComeUrl = $request->server('HTTP_REFERER');
        $guardPriviliges->typeClientAccess($request, $id, $cartShopping, $toComeUrl);
        return redirect(url()->previous())->with('success_add_to_card', 'Product add Successfully');
    }
}
