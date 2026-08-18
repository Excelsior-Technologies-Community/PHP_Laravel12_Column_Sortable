<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // Search tasks by title or description
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter tasks by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter tasks by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Filter tasks from a specific due date
        if ($request->filled('due_date_from')) {
            $query->whereDate(
                'due_date',
                '>=',
                $request->input('due_date_from')
            );
        }

        // Filter tasks up to a specific due date
        if ($request->filled('due_date_to')) {
            $query->whereDate(
                'due_date',
                '<=',
                $request->input('due_date_to')
            );
        }

        // Show only overdue incomplete tasks
        if ($request->boolean('overdue')) {
            $query->whereDate('due_date', '<', today())
                ->where('status', '!=', 'Completed');
        }

        // Apply sorting and pagination
        $tasks = $query
            ->sortable()
            ->paginate(5)
            ->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->all());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->all());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Delete multiple selected tasks.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['integer', 'exists:tasks,id'],
        ]);

        $deletedCount = Task::whereIn('id', $request->task_ids)->delete();

        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                "{$deletedCount} task(s) deleted successfully."
            );
    }
}