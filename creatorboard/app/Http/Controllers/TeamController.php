<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        return view('teams.index', [
            'teams' => Auth()::user()->teams,
        ]);

    }

    public function create()
    {
        return view('teams.create');

    }

    public function store(Request $request)
    {
      $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = auth()->user()->ownedTeams()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created successfully!');
    }


}
