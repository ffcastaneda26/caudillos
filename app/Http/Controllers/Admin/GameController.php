<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Game;
use App\Models\Round;
use App\Models\Team;
use Illuminate\Http\Request;

/**
 * Class GameController
 * @package App\Http\Controllers
 */
class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $games  = Game::paginate();

        return view('game.index', compact('games'))
            ->with('i', (request()->input('page', 1) - 1) * $games->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $game = new Game();
        $rounds = Round::orderBy('start_date')->get();
        $teams  = Team::orderby('name')->get();
        return view('game.create', compact('game','rounds','teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate(Game::$rules);

        $game = Game::create($request->all());

        return redirect()->route('games.index')
            ->with('success', 'Game created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);

        return view('game.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rounds = Round::orderBy('start_date')->get();
        $teams  = Team::orderby('name')->get();
        $game = Game::find($id);

        return view('game.edit', compact('game','teams','rounds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Game $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        request()->validate(Game::$rules);

        $game->update($request->all());

        return redirect()->route('games.index')
            ->with('success', 'Game updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $game = Game::find($id)->delete();

        return redirect()->route('games.index')
            ->with('success', 'Game deleted successfully');
    }
}
