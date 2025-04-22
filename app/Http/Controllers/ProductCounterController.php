<?php

namespace App\Http\Controllers;

use App\Models\ProjectCounter;
use Illuminate\Http\Request;

class ProjectCounterController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'project_name' => 'required|string|max:255',
            'increment_value' => 'required|string|max:255',
        ]);

        $projectCounter = ProjectCounter::create([
            'project_name' => $request->project_name,
            'increment_value' => $request->increment_value,
            'user_id' => auth()->user()->id(),
        ]);

        return response()->json(['message' => 'Project Counter created successfully!', 'data' => $projectCounter], 201);
    }


    public function index()
    {
        $projectCounters = ProjectCounter::all();
        return response()->json(['data' => $projectCounters]);
    }


    public function show($id)
    {
        $projectCounter = ProjectCounter::find($id);

        if (!$projectCounter) {
            return response()->json(['message' => 'Project Counter not found!'], 404);
        }

        return response()->json(['data' => $projectCounter]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'increment_value' => 'required|string|max:255',
        ]);

        $projectCounter = ProjectCounter::find($id);

        if (!$projectCounter) {
            return response()->json(['message' => 'Project Counter not found!'], 404);
        }

        $projectCounter->update([
            'project_name' => $request->project_name,
            'increment_value' => $request->increment_value,
            'user_id' => auth()->user()->id(),
        ]);

        return response()->json(['message' => 'Project Counter updated successfully!', 'data' => $projectCounter]);
    }


    public function destroy($id)
    {
        $projectCounter = ProjectCounter::find($id);

        if (!$projectCounter) {
            return response()->json(['message' => 'Project Counter not found!'], 404);
        }

        $projectCounter->delete();

        return response()->json(['message' => 'Project Counter deleted successfully!']);
    }
}
