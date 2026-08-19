<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TaskController extends Controller
{
    /**
     * Display active tasks.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('priority', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        /*
        |--------------------------------------------------------------------------
        | Priority Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        /*
        |--------------------------------------------------------------------------
        | Due Date From
        |--------------------------------------------------------------------------
        */
        if ($request->filled('due_date_from')) {
            $query->whereDate(
                'due_date',
                '>=',
                $request->input('due_date_from')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Due Date To
        |--------------------------------------------------------------------------
        */
        if ($request->filled('due_date_to')) {
            $query->whereDate(
                'due_date',
                '<=',
                $request->input('due_date_to')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Overdue
        |--------------------------------------------------------------------------
        */
        if ($request->boolean('overdue')) {
            $query->whereDate('due_date', '<', today())
                ->where('status', '!=', 'Completed');
        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */
        $statistics = [
            'total' => Task::count(),

            'pending' => Task::where(
                'status',
                'Pending'
            )->count(),

            'in_progress' => Task::where(
                'status',
                'In Progress'
            )->count(),

            'completed' => Task::where(
                'status',
                'Completed'
            )->count(),

            'overdue' => Task::whereDate(
                'due_date',
                '<',
                today()
            )
                ->where('status', '!=', 'Completed')
                ->count(),

            'trashed' => Task::onlyTrashed()->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Records Per Page
        |--------------------------------------------------------------------------
        */
        $perPage = (int) $request->input('per_page', 5);

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting + Pagination
        |--------------------------------------------------------------------------
        */
        $tasks = $query
            ->sortable()
            ->paginate($perPage)
            ->withQueryString();

        return view('tasks.index', compact(
            'tasks',
            'statistics',
            'perPage'
        ));
    }

    /**
     * Show task details.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Create task form.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ]);

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Edit task.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update task.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Pending,In Progress,Completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Soft delete task.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task moved to trash successfully.');
    }

    /**
     * Bulk soft delete.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['integer', 'exists:tasks,id'],
        ]);

        $deletedCount = Task::whereIn(
            'id',
            $request->task_ids
        )->delete();

        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                "{$deletedCount} task(s) moved to trash."
            );
    }

    /**
     * Export active tasks to CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Task::query();

        /*
        |--------------------------------------------------------------------------
        | Apply Same Filters As Index
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('priority', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        if ($request->filled('priority')) {
            $query->where(
                'priority',
                $request->input('priority')
            );
        }

        if ($request->filled('due_date_from')) {
            $query->whereDate(
                'due_date',
                '>=',
                $request->input('due_date_from')
            );
        }

        if ($request->filled('due_date_to')) {
            $query->whereDate(
                'due_date',
                '<=',
                $request->input('due_date_to')
            );
        }

        if ($request->boolean('overdue')) {
            $query->whereDate('due_date', '<', today())
                ->where('status', '!=', 'Completed');
        }

        $tasks = $query
            ->orderBy('id')
            ->get();

        $fileName = 'tasks-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($tasks) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Title',
                'Description',
                'Priority',
                'Status',
                'Due Date',
                'Created At',
            ]);

            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->title,
                    $task->description,
                    $task->priority,
                    $task->status,
                    optional($task->due_date)->format('Y-m-d'),
                    optional($task->created_at)->format(
                        'Y-m-d H:i:s'
                    ),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Show trash.
     */
    public function trash(Request $request)
    {
        $query = Task::onlyTrashed();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $tasks = $query
            ->latest('deleted_at')
            ->paginate(10)
            ->withQueryString();

        return view('tasks.trash', compact('tasks'));
    }

    /**
     * Restore task from trash.
     */
    public function restore(int $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);

        $task->restore();

        return redirect()
            ->route('tasks.trash')
            ->with('success', 'Task restored successfully.');
    }

    /**
     * Permanently delete task.
     */
    public function forceDelete(int $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);

        $task->forceDelete();

        return redirect()
            ->route('tasks.trash')
            ->with(
                'success',
                'Task permanently deleted.'
            );
    }

    /**
     * Empty trash.
     */
    public function emptyTrash()
    {
        Task::onlyTrashed()->forceDelete();

        return redirect()
            ->route('tasks.trash')
            ->with(
                'success',
                'Trash emptied successfully.'
            );
    }
}
