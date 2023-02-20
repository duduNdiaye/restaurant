<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Commande;
use Illuminate\Http\Request;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;


class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function client_commande()
    {
        return Inertia::render('Client/ValiderCommande', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,

        ]);
    }

    public function init()
    {
        if (!session('cart_id')) {
            session(['cart_id' => uniqid()]);
        }
        return Inertia::render('Client/Welcome');
    }

    public function addToCart(Request $request, $id)
    {
        $this->init();
        $article = Article::find($id);
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $id => ['nom' => $article->nom, 'quantity' => 1, 'prix' => $article->prix]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart[$id] = ['nom' => $article->nom, 'quantity' => 1,  'prix' => $article->prix];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function showCart()
    {
        $cart = session()->get('cart');
        return Inertia::render('Client/Welcome', ['cart' => $cart]);
    }
}
