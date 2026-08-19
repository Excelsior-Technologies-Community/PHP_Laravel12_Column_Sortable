@extends('layouts.app')

@section('title', 'Tasks | Task Manager')

@section('content')

{{-- PAGE HEADER --}}
<div class="d-flex justify-content-between page-header mb-4">

    <div>

        <div class="d-flex align-items-center gap-2 mb-1">

            <h1 class="page-title mb-0">
                Tasks
            </h1>

            <span class="badge bg-primary">
                {{ $statistics['total'] }} Total
            </span>

        </div>

        <p class="page-subtitle">
            Manage, search, filter and organize your tasks
        </p>

    </div>


    <div class="d-flex gap-2 action-header">

        <a
            href="{{ route('tasks.trash') }}"
            class="btn btn-outline-dark">

            <i class="bi bi-trash3 me-1"></i>
            Trash

            @if($statistics['trashed'] > 0)

            <span class="badge bg-danger ms-1">
                {{ $statistics['trashed'] }}
            </span>

            @endif

        </a>


        <a
            href="{{ route('tasks.export', request()->query()) }}"
            class="btn btn-outline-success">

            <i class="bi bi-download me-1"></i>
            Export CSV

        </a>


        <a
            href="{{ route('tasks.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Create Task

        </a>

    </div>

</div>


{{-- STATISTICS --}}
<div class="row g-3 section-space">

    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        Total
                    </span>

                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-list-check"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $statistics['total'] }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        Pending
                    </span>

                    <div class="stat-icon bg-secondary-subtle text-secondary">
                        <i class="bi bi-clock"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $statistics['pending'] }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        In Progress
                    </span>

                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $statistics['in_progress'] }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        Completed
                    </span>

                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $statistics['completed'] }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        Overdue
                    </span>

                    <div class="stat-icon bg-danger-subtle text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                </div>

                <div class="stat-value text-danger">
                    {{ $statistics['overdue'] }}
                </div>

            </div>

        </div>

    </div>


    <div class="col-6 col-lg-2">

        <div class="card stat-card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <span class="stat-label">
                        Trash
                    </span>

                    <div class="stat-icon bg-dark-subtle text-dark">
                        <i class="bi bi-trash3"></i>
                    </div>

                </div>

                <div class="stat-value">
                    {{ $statistics['trashed'] }}
                </div>

            </div>

        </div>

    </div>

</div>


{{-- FILTER --}}
<div class="card section-space">

    <div class="card-header">

        <div class="filter-header">

            <div>

                <div class="filter-title">

                    <i class="bi bi-funnel me-2 text-primary"></i>
                    Search & Filter Tasks

                </div>

                <small class="text-muted">
                    Find tasks quickly using multiple filters
                </small>

            </div>

        </div>

    </div>


    <div class="card-body">

        <form
            action="{{ route('tasks.index') }}"
            method="GET">

            <div class="row g-3">

                <div class="col-lg-5">

                    <label class="form-label">
                        Search
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search title or description..."
                            value="{{ request('search') }}">

                    </div>

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="Pending"
                            {{ request('status') === 'Pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option
                            value="In Progress"
                            {{ request('status') === 'In Progress' ? 'selected' : '' }}>
                            In Progress
                        </option>

                        <option
                            value="Completed"
                            {{ request('status') === 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Priority
                    </label>

                    <select
                        name="priority"
                        class="form-select">

                        <option value="">
                            All Priorities
                        </option>

                        <option
                            value="Low"
                            {{ request('priority') === 'Low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option
                            value="Medium"
                            {{ request('priority') === 'Medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option
                            value="High"
                            {{ request('priority') === 'High' ? 'selected' : '' }}>
                            High
                        </option>

                    </select>

                </div>


                <div class="col-lg-3">

                    <label class="form-label">
                        Records Per Page
                    </label>

                    <select
                        name="per_page"
                        class="form-select">

                        @foreach([5,10,25,50,100] as $number)

                        <option
                            value="{{ $number }}"
                            {{ $perPage == $number ? 'selected' : '' }}>

                            {{ $number }} records

                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-lg-3">

                    <label class="form-label">
                        Due Date From
                    </label>

                    <input
                        type="date"
                        name="due_date_from"
                        class="form-control"
                        value="{{ request('due_date_from') }}">

                </div>


                <div class="col-lg-3">

                    <label class="form-label">
                        Due Date To
                    </label>

                    <input
                        type="date"
                        name="due_date_to"
                        class="form-control"
                        value="{{ request('due_date_to') }}">

                </div>


                <div class="col-lg-3 d-flex align-items-end">

                    <div class="form-check mb-2">

                        <input
                            type="checkbox"
                            name="overdue"
                            value="1"
                            id="overdue"
                            class="form-check-input"
                            {{ request()->boolean('overdue') ? 'checked' : '' }}>

                        <label
                            for="overdue"
                            class="form-check-label">

                            <i class="bi bi-exclamation-triangle text-danger me-1"></i>
                            Overdue only

                        </label>

                    </div>

                </div>


                <div class="col-lg-3 d-flex align-items-end gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-search me-1"></i>
                        Search

                    </button>


                    <a
                        href="{{ route('tasks.index') }}"
                        class="btn btn-light border">

                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ACTIVE FILTERS --}}
@if(
request()->filled('search') ||
request()->filled('status') ||
request()->filled('priority') ||
request()->filled('due_date_from') ||
request()->filled('due_date_to') ||
request()->boolean('overdue')
)

<div class="alert active-filter d-flex align-items-center mb-4">

    <i class="bi bi-funnel-fill me-2"></i>

    <div>

        <strong>Active filters:</strong>

        @if(request()->filled('search'))
        <span class="badge bg-primary ms-1">
            Search: {{ request('search') }}
        </span>
        @endif

        @if(request()->filled('status'))
        <span class="badge bg-info text-dark ms-1">
            {{ request('status') }}
        </span>
        @endif

        @if(request()->filled('priority'))
        <span class="badge bg-warning text-dark ms-1">
            {{ request('priority') }}
        </span>
        @endif

        @if(request()->filled('due_date_from'))
        <span class="badge bg-secondary ms-1">
            From: {{ request('due_date_from') }}
        </span>
        @endif

        @if(request()->filled('due_date_to'))
        <span class="badge bg-secondary ms-1">
            To: {{ request('due_date_to') }}
        </span>
        @endif

        @if(request()->boolean('overdue'))
        <span class="badge bg-danger ms-1">
            Overdue Only
        </span>
        @endif

    </div>

</div>

@endif


{{-- BULK ACTIONS --}}
<form
    action="{{ route('tasks.bulk-destroy') }}"
    method="POST"
    id="bulkDeleteForm">

    @csrf


    <div
        id="bulkActions"
        class="card mb-3"
        style="display:none;">

        <div class="card-body py-3 d-flex justify-content-between align-items-center">

            <span class="text-muted">

                <i class="bi bi-check2-square me-1"></i>

                <strong id="selectedCount">0</strong>
                task(s) selected

            </span>


            <button
                type="submit"
                class="btn btn-danger"
                onclick="return confirm('Move selected tasks to trash?')">

                <i class="bi bi-trash3 me-1"></i>
                Delete Selected

            </button>

        </div>

    </div>


    {{-- TASK TABLE --}}
    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <h5 class="mb-1">
                    All Tasks
                </h5>

                <small class="text-muted">
                    {{ $tasks->total() }} task(s) found
                </small>

            </div>

            <span class="badge bg-light text-dark border">

                Page {{ $tasks->currentPage() }}

            </span>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="50">
                                <input
                                    type="checkbox"
                                    id="selectAll"
                                    class="form-check-input">
                            </th>

                            <th>
                                @sortablelink('id', 'ID')
                            </th>

                            <th>
                                @sortablelink('title', 'Task')
                            </th>

                            <th>
                                @sortablelink('priority', 'Priority')
                            </th>

                            <th>
                                @sortablelink('status', 'Status')
                            </th>

                            <th>
                                @sortablelink('due_date', 'Due Date')
                            </th>

                            <th>
                                @sortablelink('created_at', 'Created')
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($tasks as $task)

                        <tr>

                            <td>

                                <input
                                    type="checkbox"
                                    name="task_ids[]"
                                    value="{{ $task->id }}"
                                    class="form-check-input task-checkbox">

                            </td>


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

                                    {{ \Illuminate\Support\Str::limit($task->description, 70) }}

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

                                <div class="fw-semibold">

                                    {{ $task->due_date->format('M d, Y') }}

                                </div>

                                @if(
                                $task->due_date->isPast() &&
                                $task->status !== 'Completed'
                                )

                                <span class="badge bg-danger mt-1">

                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Overdue

                                </span>

                                @endif

                                @else

                                <span class="text-muted">
                                    —
                                </span>

                                @endif

                            </td>


                            <td>

                                <span class="text-muted">

                                    {{ $task->created_at->format('M d, Y') }}

                                </span>

                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="{{ route('tasks.show', $task) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="View">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    <a
                                        href="{{ route('tasks.edit', $task) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <form
                                        action="{{ route('tasks.destroy', $task) }}"
                                        method="POST"
                                        onsubmit="return confirm('Move this task to trash?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Move to Trash">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state">

                                <div class="empty-state-icon">

                                    <i class="bi bi-inbox"></i>

                                </div>

                                <h5 class="fw-bold">
                                    No tasks found
                                </h5>

                                <p class="text-muted mb-3">
                                    Try changing your search or filters.
                                </p>

                                <a
                                    href="{{ route('tasks.create') }}"
                                    class="btn btn-primary">

                                    <i class="bi bi-plus-lg me-1"></i>
                                    Create Task

                                </a>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($tasks->total() > 0)

        <div class="card-footer bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="text-muted small">

                    Showing

                    <strong>
                        {{ $tasks->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $tasks->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $tasks->total() }}
                    </strong>

                    tasks

                </div>


                @if($tasks->hasPages())

                {{ $tasks->withQueryString()->links('pagination::bootstrap-5') }}

                @endif

            </div>

        </div>

        @endif

    </div>

</form>


@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectAll = document.getElementById('selectAll');

        const checkboxes =
            document.querySelectorAll('.task-checkbox');

        const bulkActions =
            document.getElementById('bulkActions');

        const selectedCount =
            document.getElementById('selectedCount');


        function updateBulkActions() {

            const selected =
                document.querySelectorAll(
                    '.task-checkbox:checked'
                );

            const count = selected.length;

            selectedCount.textContent = count;

            bulkActions.style.display =
                count > 0 ? 'block' : 'none';

            selectAll.checked =
                checkboxes.length > 0 &&
                count === checkboxes.length;

            selectAll.indeterminate =
                count > 0 &&
                count < checkboxes.length;

        }


        selectAll.addEventListener('change', function() {

            checkboxes.forEach(function(checkbox) {

                checkbox.checked =
                    selectAll.checked;

            });

            updateBulkActions();

        });


        checkboxes.forEach(function(checkbox) {

            checkbox.addEventListener(
                'change',
                updateBulkActions
            );

        });


        updateBulkActions();

    });
</script>

@endpush