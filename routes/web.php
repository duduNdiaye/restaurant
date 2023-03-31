<?php

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Commande;
use App\Models\MenuJour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\MenuJourController;
use App\Mail\SendNewCommandeMail;

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

                $commandes = Commande::where('restaurantId',Auth::id())->get();
                $commandes_count=Commande::where('restaurantId',Auth::id())->count();
                $articles_count=Article::where('user_id',Auth::id())->count();
                $clients=Commande::select('nomClient','numeroClient','email')->where('restaurantId',Auth::id())->distinct()->count();
                $revenu=Commande::where('restaurantId',Auth::id())->sum('coutTotal');

                return Inertia::render(
                    'Restaurant/Dashboard',
                    [
                        'revenu_total'=>$revenu,
                        'nbre_clients'=>$clients,
                        'nbre_articles'=>$articles_count,
                        'nbre_commandes'=>$commandes_count,
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
        $ordersByDayOfWeek = Commande::selectRaw('DATE_FORMAT(date, "%W") as dayOfWeek, COUNT(*) as totalOrders')
        ->groupBy('dayOfWeek')->orderBy('dayOfWeek')
        ->get();
        $total_commandes=Commande::where('restaurantId',Auth::id())->count();
        return Inertia::render('Restaurant/DashboardStats',
    [
        'total_commandes'=>$total_commandes,
        'commandes_par_jour'=>$ordersByDayOfWeek,
    ]);
    })->name('dashboard.stats');
    Route::get('dashboard/menu', [MenuJourController::class, 'index'])->name('dashboard.menu');
    Route::post('/menu/new', [MenuJourController::class, 'store'])->name('store.menu');
    Route::put('/menu/edit', [MenuJourController::class, 'update'])->name('edit.menu');
    Route::delete('/menu/delete', [MenuJourController::class,'destroy'])->name('delete.menu');
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
            'adresse' => $request->AdresseClient,
            'restaurantId' => $request->IDrestaurant,
            'email' => $request->mailclient
        ]);
        $nomC = $request->NomClient;
        $resto = $request->Lerestaurant;
        $numCommande = $request->orderId;
        $date = $request->laDate;
        $heure = $request->Lheure;
        Mail::to($request->mailclient)->send(new SendNewCommandeMail($nomC, $resto, $numCommande, $date, $heure));
    })->name('validation.commande');





    Route::post('/note', function (Request $request) {
        $user = User::findOrFail($request->user_id);
        $oldNotation = $user->notation ?? 0; // si notation n'existe pas, on initialise à 0
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
