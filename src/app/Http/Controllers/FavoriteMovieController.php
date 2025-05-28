<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use App\Http\Requests\StoreFavoriteMovieRequest;
use App\Http\Requests\UpdateFavoriteMovieRequest;

class FavoriteMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoriteMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteMovie $favoriteMovie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteMovie $favoriteMovie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteMovieRequest $request, FavoriteMovie $favoriteMovie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteMovie $favoriteMovie)
    {
        //
    }
}
