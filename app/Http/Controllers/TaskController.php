<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showClosed = $request->input('showClosed', false);
        $sortBy = $request->input('sortBy', 'id'); 
        $sortOrder = $request->input('sortOrder', 'asc'); 
    
        $tasks = Task::when(!$showClosed, function ($query) {
            $query->where('is_closed', false);
        })
        ->orderBy($sortBy, $sortOrder)
        ->get();
    
        return view('tasks.index', compact('tasks', 'showClosed', 'sortBy', 'sortOrder'));
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Attività creata con successo.');
    }

    public function complete(Task $task)
    {
        $task->update(['is_closed' => true]);

        return redirect()->route('tasks.index')->with('success', 'Attività completata con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'is_closed' => 'boolean',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Attività aggiornata con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        {
            $task->delete();
    
            return redirect()->route('tasks.index')->with('success', 'Attività eliminata con successo.');
        }
    }
}
