<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get both owned teams and teams the user is a member of
        $ownedTeams = $user->ownedTeams;
        $memberTeams = $user->teams;
        
        // Merge and remove duplicates
        $allTeams = $ownedTeams->merge($memberTeams)->unique('id');
        
        return view('teams.index', [
            'teams' => $allTeams,
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

        $user = auth()->user();
        $user->current_team_id = $team->id;
        $user->save();

        return redirect()->route('teams.index')->with('success', 'Team created successfully!');
    }


}
