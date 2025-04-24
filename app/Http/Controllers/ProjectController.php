<?php

namespace App\Http\Controllers;

use App\Events\WriteProjectContent;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Project::where('user_id', Auth::id())->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'sometimes|string',
            'markdown_content' => 'nullable|string',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'markdown_content' => $request->markdown_content,
        ]);

        if (!$project->markdown_content) {
            event(new WriteProjectContent($project));
        }

        return back(303)->with('success', 'Projet créé avec succès.');
    }

    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($project->load('sections'));
    }
}
