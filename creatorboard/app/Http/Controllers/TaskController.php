<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorizeProject($project);
        $tasks = $project->tasks()->latest()->get();
        return view('tasks.index', compact('tasks','project'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        $this->authorizeProject($project);
        $users = $project->team->users;
        return view('tasks.create', compact('users','project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project,Request $request)
    {
       $this->authorizeProject($project);
       $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'nullable|string',
           'status' => 'required|in:todo,in-progress,done',
           'priority' => 'required|in:low,medium,high',
           'due_date' => 'nullable|date',
           'assigned_to' => 'nullable|exists:users,id',
       ]);

       $project->tasks()->create($request->all());
       return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project,Task $task)
    {
        $this->authorizeProject($project);
        return view('tasks.show', compact('project','task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project,Task $task)
    {
        $this->authorizeProject($project);
        $users = $project->team->users;
        return view('tasks.edit', compact('users','project','task'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Project $project,Request $request, Task $task)
    {
        $this->authorizeProject($project);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in-progress,done',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($request->all());
        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project,Task $task)
    {
        $this->authorizeProject($project);
        $task->delete();
        return back()->with('success', 'Task deleted successfully');
    }

    public function authorizeProject(Project $project)
    {
        if(Auth::user()->current_team_id != $project->team_id){

            abort(403,'You are not authorized to perform this action');
        }
    }
}
