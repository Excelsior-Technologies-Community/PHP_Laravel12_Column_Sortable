@extends('layouts.app')

@section('title', 'Task Trash | Task Manager')

@section('content')

<div class="d-flex justify-content-between page-header mb-4">

    <div>

        <div class="d-flex align-items-center gap-2 mb-1">

            <h1 class="page-title mb-0">

                <i class="bi bi-trash3 text-danger me-2"></i>
                Task Trash

            </h1>

            <span class="badge bg-danger">
                {{ $tasks->total() }}
            </span>

        </div>

        <p class="page-subtitle">
            Restore deleted tasks or permanently remove them
        </p>

    </div>


    <div class="d-flex gap-2 action-header">

        <a
            href="{{ route('tasks.index') }}"
            class="btn btn-light border">

            <i class="bi bi-arrow-left me-1"></i>
            Back to Tasks

        </a>


        @if($tasks->count() > 0)

        <form
            action="{{ route('tasks.empty-trash') }}"
            method="POST"
            onsubmit="return confirm('Permanently delete ALL trashed tasks? This cannot be undone.')">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger">

                <i class="bi bi-trash3 me-1"></i>
                Empty Trash

            </button>

        </form>

        @endif

    </div>

</div>


{{-- SEARCH --}}
<div class="card mb-4">

    <div class="card-body">

        <form
            action="{{ route('tasks.trash') }}"
            method="GET">

            <div class="row g-3">

                <div class="col-lg-8">

                    <label class="form-label">
                        Search Deleted Tasks
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search by title or description..."
                            value="{{ request('search') }}">

                    </div>

                </div>


                <div class="col-lg-4 d-flex align-items-end gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-search me-1"></i>
                        Search

                    </button>


                    <a
                        href="{{ route('tasks.trash') }}"
                        class="btn btn-light border">

                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- TABLE --}}
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <div>

            <h5 class="mb-1">
                Deleted Tasks
            </h5>

            <small class="text-muted">
                Tasks currently in trash
            </small>

        </div>


        <span class="badge bg-dark">

            {{ $tasks->total() }}
            deleted

        </span>

    </div>


    <div class="card-body p-0">

        @if($tasks->count())

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Task
                        </th>

                        <th>
                            Priority
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Due Date
                        </th>

                        <th>
                            Deleted At
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($tasks as $task)

                    <tr>

                        <td>

                            <span class="fw-semibold">
                                #{{ $task->id }}
                            </span>

                        </td>


                        <td>

                            <div class="task-title">
                                {{ $task->title }}
                            </div>

                            @if($task->description)

                            <div class="task-description">

                                {{ Str::limit($task->description, 60) }}

                            </div>

                            @endif

                        </td>


                        <td>

                            @php

                            $priorityClass = [
                            'High' => 'danger',
                            'Medium' => 'warning',
                            'Low' => 'success',
                            ];

                            @endphp

                            <span class="badge bg-{{ $priorityClass[$task->priority] ?? 'secondary' }}">

                                {{ $task->priority }}

                            </span>

                        </td>


                        <td>

                            @php

                            $statusClass = [
                            'Completed' => 'success',
                            'In Progress' => 'info',
                            'Pending' => 'secondary',
                            ];

                            @endphp

                            <span class="badge bg-{{ $statusClass[$task->status] ?? 'secondary' }}">

                                {{ $task->status }}

                            </span>

                        </td>


                        <td>

                            @if($task->due_date)

                            {{ $task->due_date->format('d M Y') }}

                            @else

                            <span class="text-muted">
                                —
                            </span>

                            @endif

                        </td>


                        <td>

                            <div class="fw-semibold">

                                {{ $task->deleted_at->format('d M Y') }}

                            </div>

                            <small class="text-muted">

                                {{ $task->deleted_at->format('h:i A') }}

                            </small>

                        </td>


                        <td>

                            <div class="action-buttons">

                                {{-- RESTORE --}}
                                <form
                                    action="{{ route('tasks.restore', $task->id) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-success"
                                        title="Restore Task">

                                        <i class="bi bi-arrow-counterclockwise"></i>

                                    </button>

                                </form>


                                {{-- PERMANENT DELETE --}}
                                <form
                                    action="{{ route('tasks.force-delete', $task->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Permanently delete this task? This cannot be undone.')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Delete Permanently">

                                        <i class="bi bi-trash3"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @else

        <div class="empty-state">

            <div class="empty-state-icon">

                <i class="bi bi-trash3"></i>

            </div>

            <h5 class="fw-bold">
                Trash is empty
            </h5>

            <p class="text-muted">
                Deleted tasks will appear here.
            </p>

            <a
                href="{{ route('tasks.index') }}"
                class="btn btn-primary">

                <i class="bi bi-arrow-left me-1"></i>
                Back to Tasks

            </a>

        </div>

        @endif

    </div>


    @if($tasks->hasPages())

    <div class="card-footer bg-white">

        {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}

    </div>

    @endif

</div>

@endsection