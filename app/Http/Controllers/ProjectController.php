<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function index()
    {
        $projects = Project::with('todos')->get();
        return view('dashboard', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        Project::create($request->all());
        return redirect()->back()->with('success', 'Project created successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully!');
    }
    




    public function exportGist(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'project_id' => 'required|exists:projects,id',
    ]);

    // Fetch the project with the given ID and its associated todos
    $project = Project::with('todos')->findOrFail($request->project_id);

    // Count completed and total todos
    $totalTodos = $project->todos->count();
    $completedTodos = $project->todos->where('status', true)->count();

    // Start formatting the markdown content
    $markdownContent = "# " . $project->title . "\n\n";
    $markdownContent .= "Summary: {$completedTodos} / {$totalTodos} todos completed.\n\n";

    // Section 1: Task list of pending todos
    $markdownContent .= "## Section 1: Pending Tasks\n";
    foreach ($project->todos as $todo) {
        if (!$todo->status) {
            $markdownContent .= "- [ ] **{$todo->description}**\n"; // Open checkbox for pending
        }
    }

    // Section 2: Task list of completed todos
    $markdownContent .= "\n## Section 2: Completed Tasks\n";
    foreach ($project->todos as $todo) {
        if ($todo->status) {
            $markdownContent .= "- [x] **{$todo->description}**\n"; // Checked checkbox for completed
        }
    }

    // Save the Markdown file locally
    $fileName = storage_path("app/{$project->title}.md"); // Define the file path
    file_put_contents($fileName, $markdownContent); // Write the content to the file

    // GitHub Gist API Endpoint
    $url = 'https://api.github.com/gists';

    // GitHub Token (preferably set in .env)
    $githubToken = env('GITHUB_TOKEN');

    // Create a new gist using GitHub API
    $response = Http::withToken($githubToken)->post($url, [
        'files' => [
            "{$project->title}.md" => [ // File name as project title
                'content' => $markdownContent,
            ],
        ],
        'description' => "Project Summary for {$project->title}",
        'public' => false, // Make it a secret gist
    ]);

    // Check for successful response
    if ($response->successful()) {
        return redirect()->route('dashboard')->with('success', 'Gist created and file saved successfully!');
    }

    // If the response was not successful, return an error
    return back()->withErrors('Failed to export gist.');
}



}
