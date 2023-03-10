<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\MenuJour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MenuJourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $m_id=Auth::id();
        $articles=Article::where('user_id',$m_id)->get();
        $menus=MenuJour::with('articles')->get();
        return Inertia::render('Restaurant/Menu/MenuSemaine',
            [
        'articles'=>$articles,
        'menus'=>$menus
            ]
        );
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
        //
        $data = $request->validate([
            'jour_semaine' => 'required|string|max:20',
            'selectedArticles' => 'required|array',
            'selectedArticles.*' => 'integer',
        ]);
        $monMenu = MenuJour::create([
            'jour_semaine' => $data['jour_semaine'],
            'articles'=>'xnxn'
        ]);
        // foreach ($request->input('selectedArticles') as $article) {
        //     $monMenu->articles()->attach($article);
        // }
        $monMenu->articles()->attach($data['selectedArticles']);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuJour  $menuJour
     * @return \Illuminate\Http\Response
     */
    public function show(MenuJour $menuJour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuJour  $menuJour
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuJour $menuJour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuJour  $menuJour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuJour $menuJour)
    {
        //
        $data = $request->validate([
            'jour_semaine' => 'required|string|max:20',
            'selectedArticles' => 'required|array',
            'selectedArticles.*' => 'integer',
        ]);

        $menuJour->jour_semaine=$data['jour_semaine'];
        $alpha=$menuJour->id;
        $menuJour->updateOrFail();
        $menuJour->articles()->detach();
        $menuJour->articles()->attach($data['selectedArticles']);
        // foreach ($request->input('selectedArticles') as $article) {
        //     $menuJour->articles()->attach([$article=>['menu_jour_id'=>$menuJour->id]]);
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuJour  $menuJour
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuJour $menuJour)
    {
        //
        $menuJour->articles()->detach();
        $menuJour->delete();
    }
}
