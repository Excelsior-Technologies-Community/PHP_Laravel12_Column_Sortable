@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tasks List</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Task
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>@sortablelink('id', 'ID')</th>
                            <th>@sortablelink('title', 'Title')</th>
                            <th>@sortablelink('priority', 'Priority')</th>
                            <th>@sortablelink('status', 'Status')</th>
                            <th>@sortablelink('due_date', 'Due Date')</th>
                            <th>@sortablelink('created_at', 'Created')</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->title }}</td>
                                <td>
                                    @php
                                        $priorityClass = [
                                            'High' => 'danger',
                                            'Medium' => 'warning',
                                            'Low' => 'success'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $priorityClass[$task->priority] }}">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Completed' => 'success',
                                            'In Progress' => 'info',
                                            'Pending' => 'secondary'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusClass[$task->status] }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($task->due_date)
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                        @if(\Carbon\Carbon::parse($task->due_date)->isPast() && $task->status != 'Completed')
                                            <span class="badge bg-danger">Overdue</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $task->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No tasks found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $tasks->appends(request()->query())->links() }}
            </div>

            <div class="text-muted mt-2">
                Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} tasks
            </div>
        </div>
    </div>
@endsection