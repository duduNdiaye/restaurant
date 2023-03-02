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
    Route::get('/dashboard', function () {
        switch (Auth::user()->role) {
            case 'restaurant':
                $articles = Article::where('user_id', Auth::id())->paginate(3);
                $commandes=Commande::all();
                return Inertia::render(
                    'Restaurant/Dashboard',
                    [
                        'articles' => $articles,
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
});

Route::controller(CommandeController::class)->group(function () {
    Route::get('/commandes', 'client_commande')->name('client.commande');
    Route::put('/validation', 'create_commande')->name('validation');
});
Route::post('/article/new',[ArticleController::class,'store'])->name('store.article');
Route::put('article/edit/{article}',[ArticleController::class,'update'])->name('update.article');
Route::delete('article/delete/{article}', [ArticleController::class,'destroy'])->name('delete.article');
