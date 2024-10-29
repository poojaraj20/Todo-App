<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Project;

class TodoController extends Controller
{
    //
    public function store(Request $request, Project $project)
    {
        $request->validate(['description' => 'required|string|max:255']);
        $project->todos()->create($request->all());
        return redirect()->back()->with('success', 'Todo created successfully!');
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());
        return redirect()->back()->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->back()->with('success', 'Todo deleted successfully!');
    }
}
