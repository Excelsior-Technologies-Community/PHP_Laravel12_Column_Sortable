@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Task Details</h1>
        <p class="text-muted mb-0">
            View complete information about this task.
        </p>
    </div>

    <div class="d-flex gap-2">
        <a
            href="{{ route('tasks.index') }}"
            class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

        <a
            href="{{ route('tasks.edit', $task) }}"
            class="btn btn-warning">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    </div>
</div>

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-info-circle"></i>
            Task Information
        </h5>
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <strong>ID</strong>
                <div class="mt-1">
                    #{{ $task->id }}
                </div>
            </div>

            <div class="col-md-6">
                <strong>Title</strong>
                <div class="mt-1">
                    {{ $task->title }}
                </div>
            </div>

            <div class="col-md-12">
                <strong>Description</strong>

                <div class="border rounded p-3 mt-2 bg-light">
                    {!! nl2br(e($task->description ?: 'No description available.')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <strong>Priority</strong>

                <div class="mt-2">
                    @if($task->priority === 'High')
                    <span class="badge bg-danger">
                        High
                    </span>
                    @elseif($task->priority === 'Medium')
                    <span class="badge bg-warning text-dark">
                        Medium
                    </span>
                    @else
                    <span class="badge bg-success">
                        Low
                    </span>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <strong>Status</strong>

                <div class="mt-2">
                    @if($task->status === 'Completed')
                    <span class="badge bg-success">
                        Completed
                    </span>
                    @elseif($task->status === 'In Progress')
                    <span class="badge bg-primary">
                        In Progress
                    </span>
                    @else
                    <span class="badge bg-secondary">
                        Pending
                    </span>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <strong>Due Date</strong>

                <div class="mt-2">
                    @if($task->due_date)
                    {{ $task->due_date->format('d-m-Y') }}

                    @if(
                    $task->due_date->isPast() &&
                    $task->status !== 'Completed'
                    )
                    <span class="badge bg-danger ms-1">
                        Overdue
                    </span>
                    @endif
                    @else
                    <span class="text-muted">
                        No due date
                    </span>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <strong>Created At</strong>

                <div class="mt-1">
                    {{ $task->created_at->format('d-m-Y H:i') }}
                </div>
            </div>

            <div class="col-md-6">
                <strong>Last Updated</strong>

                <div class="mt-1">
                    {{ $task->updated_at->format('d-m-Y H:i') }}
                </div>
            </div>

        </div>

    </div>
</div>

@endsection