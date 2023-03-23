<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
            $m_id=Auth::id();
            $articles=Article::when($request->search, function ($query, $search) {
                $query->where('nom', 'like', '%' . $search . '%')
                    ->OrWhere('categorie', 'like', '%' . $search . '%');
            })->where('user_id',$m_id)->with('user')->paginate(5)->withQueryString();
            return Inertia::render('Restaurant/Tablearticles',
            ['articles' => $articles,
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' =>'required|string',
            'prix'=> 'required|min:100|integer',
            'categorie'=>'required',
            'quantite'=>'required',
            // 'ingredients'=>'required',
            'tempsPreparation'=>'required',
            'description'=>'required',


        ]);
        //
        $article=new Article($request->all());
        $article->user_id=Auth::id();
        $article->saveOrFail();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'nom' =>'required|string',
            'prix'=> 'required|min:100|integer',
            'categorie'=>'required',
            'quantite'=>'required',
            // 'ingredients'=>'required',
            'tempsPreparation'=>'required',
            'description'=>'required',


        ]);
        //
        $article->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->deleteOrFail();
        //
    }
}
