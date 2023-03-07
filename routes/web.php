<?php

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\MenuJourController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $articles = Article::all();
    $users = User::where('role', 'restaurant')->get();
    return Inertia::render('Client/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'articles' => $articles,
        'users' => $users
    ]);
})->name('acceuil');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        switch (Auth::user()->role) {
            case 'restaurant':
                // $articles = Article::when($request->search,function($query,$searchTerm){
                //     $query->where('nom','like','%'.$searchTerm.'%')
                //     ->OrWhere('categorie','like','%'.$searchTerm.'%');
                // })->where('user_id', Auth::id())->paginate(5)->withQueryString();

                $commandes=Commande::all();
                return Inertia::render(
                    'Restaurant/Dashboard',
                    [

                        'commandes'=>$commandes

                    ]
                );
                break;

            case 'super-admin':
                return Inertia::render('SuperAdmin/Dashboard');
                break;

            default:
                abort(403);
                break;
        }
    })->name('dashboard');
    Route::get('/dashboard/articles', [ArticleController::class,'index'])->name('articles.list');
    Route::get('dashboard/menu',[MenuJourController::class,'index']);
    Route::post('/menu/new',[MenuJourController::class,'store'])->name('store.menu');
});

Route::group(['prefix' => 'commandes'], function () {
    Route::get('/', [CommandeController::class, 'client_commande'])->name('client.commande');
    Route::post('/validation', function (Request $request) {
        Commande::create([
            'nomClient' => $request->NomClient,
            'numeroClient' => $request->TelClient,
            'coutTotal' => $request->Total,
            'commentaire' => $request->MonCommentaire,
            'modeReception' => $request->TypeReception,
            'panier' => json_encode($request->panierr),
            'numeroCommande' => $request->orderId,
            'date' => $request->laDate,
            'heure' => $request->Lheure,
            'adresse' => $request->AdresseClient
        ]);

    })->name('validation.commande');
});

Route::post('/article/new',[ArticleController::class,'store'])->name('store.article');
Route::put('article/edit/{article}',[ArticleController::class,'update'])->name('update.article');
Route::delete('article/delete/{article}', [ArticleController::class,'destroy'])->name('delete.article');
