<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class CurrentTeamController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        $team = Team::findOrFail($request->team_id);

        if(!$team->user->contains(Auth::id())) {
            abort(403, 'You do not belong to this team.');
        }

        Auth::user()->update(['current_team_id' => $team->id]);

        return redirect()->back()->with('success', 'Current team updated successfully!');
    }

    public function destroy(){
        $this->authorize('delete', Auth::user()->currentTeam);

        if($team->owner_id !== Auth::id()) {
            abort(403, 'You do not have permission to delete this team.');
        }
        $team->delete();

        if(Auth::user()->current_team_id === $team->id) {
            Auth::user()->update(['current_team_id' => null]);
        }

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }
}
