<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use App\Models\Commande;
use Illuminate\Http\Request;
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

    public function restaurant()
    {
        return Inertia::render('Client/RestaurantDetails', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,

        ]);
    }

    public function getArticles()
    {
        $articles = Article::all();

        return response()->json($articles);
    }


    public function create_commande(Request $request)
    {
        Commande::create([
            'nomClient' => $request->input('nom'),
            'numeroClient' => $request->input('telephone'),
            'coutTotal' => $request->input('total'),
            'commentaire' => $request->input('commentaires'),
            'modeReception' => $request->input('reception'),
            'panier' => json_decode($request->input('cart_data')),
            'numeroCommande' => $request->input('order_id'),
            'date' => $request->input('ladate'),
            'heure' => $request->input('heures'),
            'adresse' => $request->input('adresse')
        ]);

        $commande = new Commande;
        $commande->nomClient = $request->input('nom');
        $commande->numeroClient = $request->input('telephone');
        $commande->coutTotal = $request->input('total');
        $commande->commentaire = $request->input('commentaires');
        $commande->modeReception = $request->input('reception');
        $commande->panier = json_decode($request->input('cart_data'));
        $commande->numeroCommande = $request->input('order_id');
        $commande->date = $request->input('ladate');
        $commande->heure = $request->input('heures');
        $commande->adresse = $request->input('adresse');

        $commande->save();
        return response()->json(['message' => 'La commande a été créée avec succès'], 201);
    }
}
