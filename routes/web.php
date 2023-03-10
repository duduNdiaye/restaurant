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
use App\Models\MenuJour;
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

                $commandes = Commande::all();
                return Inertia::render(
                    'Restaurant/Dashboard',
                    [

                        'commandes' => $commandes

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
    Route::get('/dashboard/articles', [ArticleController::class, 'index'])->name('articles.list');
    Route::get('/dashboard/stats', function () {
        return Inertia::render('Restaurant/DashboardStats');
    })->name('dashboard.stats');
    Route::get('dashboard/menu', [MenuJourController::class, 'index'])->name('dashboard.menu');
    Route::post('/menu/new', [MenuJourController::class, 'store'])->name('store.menu');
    Route::put('/menu/edit', [MenuJourController::class, 'update'])->name('edit.menu');
    Route::get('/restau/profile', function () {
        $auth_user = User::findOrFail(Auth::id());
        $articles = Article::where('user_id', Auth::id())->count();
        return Inertia::render('Restaurant/Profile/ProfileInfo', [
            'user' => $auth_user,
            'articles' => $articles
        ]);
    })->name('restau.profile');
});

Route::group(['prefix' => 'commandes'], function () {
    Route::get('/', [CommandeController::class, 'client_commande'])->name('client.commande');
    Route::get('/restaurant/{id}', function (int $id) {
        $usere = User::findOrFail($id);
        $menu = MenuJour::where('user_id', $usere->id)->with('articles')->get();
        $articles = Article::all();
        return Inertia::render('Client/RestaurantDetails', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'usere' => $usere,
            'articles' => $articles,
            'menu' => $menu


        ]);
    })->name('restaurant.details');
    Route::get('/resto', function () {

        $users = User::where('role', 'restaurant')->get();
        return Inertia::render('Client/Restaurant', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'users' => $users



        ]);
    })->name('resto.accueil');
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





    Route::post('/note', function (Request $request) {
        $user = User::findOrFail($request->user_id);
        $oldNotation = $user->notation ?? 0; // si notation n'existe pas, on initialise ?? 0
        $newNotation = $request->note;
        $lesnotes = $user->nombrenote ?? 0;
        if ($oldNotation == 0) {
            $avgNotation = $newNotation;
        } else {
            $avgNotation = round(($oldNotation + $newNotation) / 2, 1);
        }


        $user->update([
            'notation' => $avgNotation,
            'nombrenote' => $lesnotes + 1
        ]);
    })->name('note.resto');
});

Route::post('/article/new', [ArticleController::class, 'store'])->name('store.article');
Route::put('article/edit/{article}', [ArticleController::class, 'update'])->name('update.article');
Route::delete('article/delete/{article}', [ArticleController::class, 'destroy'])->name('delete.article');
