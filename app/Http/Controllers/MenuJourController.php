<?php

namespace App\Http\Controllers;

use App\Models\MenuJour;
use Illuminate\Http\Request;

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
        $monMenu=new MenuJour($request->all());
        $monMenu->saveOrFail();

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
        $menuJour->updateOrFail($request->all());

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
        $menuJour->deleteOrFail();
    }
}
