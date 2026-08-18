@extends('layouts.app')

@section('content')

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>Tasks List</h1>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Task
        </a>

    </div>


    {{-- Search and Filter Card --}}
    <div class="card mb-4">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="bi bi-search"></i>
                Search & Filter Tasks
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('tasks.index') }}" method="GET">

                {{-- First Row --}}
                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-5">

                        <label for="search" class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Search by title or description..."
                            value="{{ request('search') }}"
                        >

                    </div>


                    {{-- Status Filter --}}
                    <div class="col-md-3">

                        <label for="status" class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                        >

                            <option value="">
                                All Statuses
                            </option>

                            <option
                                value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="In Progress"
                                {{ request('status') === 'In Progress' ? 'selected' : '' }}
                            >
                                In Progress
                            </option>

                            <option
                                value="Completed"
                                {{ request('status') === 'Completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                        </select>

                    </div>


                    {{-- Priority Filter --}}
                    <div class="col-md-2">

                        <label for="priority" class="form-label">
                            Priority
                        </label>

                        <select
                            name="priority"
                            id="priority"
                            class="form-select"
                        >

                            <option value="">
                                All Priorities
                            </option>

                            <option
                                value="Low"
                                {{ request('priority') === 'Low' ? 'selected' : '' }}
                            >
                                Low
                            </option>

                            <option
                                value="Medium"
                                {{ request('priority') === 'Medium' ? 'selected' : '' }}
                            >
                                Medium
                            </option>

                            <option
                                value="High"
                                {{ request('priority') === 'High' ? 'selected' : '' }}
                            >
                                High
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Second Row --}}
                <div class="row g-3 mt-1">

                    {{-- Due Date From --}}
                    <div class="col-md-3">

                        <label for="due_date_from" class="form-label">
                            Due Date From
                        </label>

                        <input
                            type="date"
                            name="due_date_from"
                            id="due_date_from"
                            class="form-control"
                            value="{{ request('due_date_from') }}"
                        >

                    </div>


                    {{-- Due Date To --}}
                    <div class="col-md-3">

                        <label for="due_date_to" class="form-label">
                            Due Date To
                        </label>

                        <input
                            type="date"
                            name="due_date_to"
                            id="due_date_to"
                            class="form-control"
                            value="{{ request('due_date_to') }}"
                        >

                    </div>


                    {{-- Overdue Filter --}}
                    <div class="col-md-3 d-flex align-items-end">

                        <div class="form-check mb-2">

                            <input
                                type="checkbox"
                                name="overdue"
                                value="1"
                                id="overdue"
                                class="form-check-input"
                                {{ request()->boolean('overdue') ? 'checked' : '' }}
                            >

                            <label
                                for="overdue"
                                class="form-check-label"
                            >
                                <i class="bi bi-exclamation-triangle text-danger"></i>
                                Show overdue tasks only
                            </label>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-md-3 d-flex align-items-end gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-search"></i>
                            Search
                        </button>

                        <a
                            href="{{ route('tasks.index') }}"
                            class="btn btn-secondary"
                            title="Clear search and filters"
                        >
                            <i class="bi bi-x-circle"></i>
                            Clear
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Active Filters --}}
    @if(
        request()->filled('search') ||
        request()->filled('status') ||
        request()->filled('priority') ||
        request()->filled('due_date_from') ||
        request()->filled('due_date_to') ||
        request()->boolean('overdue')
    )

        <div class="alert alert-info d-flex align-items-center mb-4">

            <i class="bi bi-funnel me-2"></i>

            <div>

                <strong>Active filters:</strong>

                @if(request()->filled('search'))

                    <span class="badge bg-primary ms-1">
                        Search: {{ request('search') }}
                    </span>

                @endif


                @if(request()->filled('status'))

                    <span class="badge bg-info text-dark ms-1">
                        Status: {{ request('status') }}
                    </span>

                @endif


                @if(request()->filled('priority'))

                    <span class="badge bg-warning text-dark ms-1">
                        Priority: {{ request('priority') }}
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


    {{-- Bulk Delete Form --}}
    <form
        action="{{ route('tasks.bulk-destroy') }}"
        method="POST"
        id="bulkDeleteForm"
    >

        @csrf

        {{-- Bulk Actions --}}
        <div
            class="d-flex justify-content-between align-items-center mb-3"
            id="bulkActions"
            style="display: none !important;"
        >

            <div>

                <span class="text-muted">
                    <strong id="selectedCount">0</strong>
                    task(s) selected
                </span>

            </div>

            <button
                type="submit"
                class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete the selected tasks?')"
            >

                <i class="bi bi-trash"></i>
                Delete Selected

            </button>

        </div>


        {{-- Tasks Table --}}
        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                {{-- Select All --}}
                                <th width="50">

                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="selectAll"
                                        title="Select all tasks"
                                    >

                                </th>


                                <th>
                                    @sortablelink('id', 'ID')
                                </th>

                                <th>
                                    @sortablelink('title', 'Title')
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

                                    {{-- Checkbox --}}
                                    <td>

                                        <input
                                            type="checkbox"
                                            name="task_ids[]"
                                            value="{{ $task->id }}"
                                            class="form-check-input task-checkbox"
                                        >

                                    </td>


                                    {{-- ID --}}
                                    <td>
                                        {{ $task->id }}
                                    </td>


                                    {{-- Title --}}
                                    <td>

                                        <strong>
                                            {{ $task->title }}
                                        </strong>

                                        @if($task->description)

                                            <div class="small text-muted">

                                                {{ \Illuminate\Support\Str::limit(
                                                    $task->description,
                                                    70
                                                ) }}

                                            </div>

                                        @endif

                                    </td>


                                    {{-- Priority --}}
                                    <td>

                                        @php

                                            $priorityClass = [
                                                'High' => 'danger',
                                                'Medium' => 'warning',
                                                'Low' => 'success',
                                            ];

                                        @endphp

                                        <span
                                            class="badge bg-{{ $priorityClass[$task->priority] }}"
                                        >
                                            {{ $task->priority }}
                                        </span>

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @php

                                            $statusClass = [
                                                'Completed' => 'success',
                                                'In Progress' => 'info',
                                                'Pending' => 'secondary',
                                            ];

                                        @endphp

                                        <span
                                            class="badge bg-{{ $statusClass[$task->status] }}"
                                        >
                                            {{ $task->status }}
                                        </span>

                                    </td>


                                    {{-- Due Date --}}
                                    <td>

                                        @if($task->due_date)

                                            {{ $task->due_date->format('M d, Y') }}

                                            @if(
                                                $task->due_date->isPast() &&
                                                $task->status !== 'Completed'
                                            )

                                                <span class="badge bg-danger">
                                                    Overdue
                                                </span>

                                            @endif

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Created Date --}}
                                    <td>

                                        {{ $task->created_at->format('M d, Y') }}

                                    </td>


                                    {{-- Actions --}}
                                    <td>

                                        <a
                                            href="{{ route('tasks.edit', $task) }}"
                                            class="btn btn-sm btn-warning"
                                            title="Edit task"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>


                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            title="Delete task"
                                            onclick="deleteSingleTask({{ $task->id }})"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="bi bi-inbox fs-1 text-muted d-block mb-3"
                                        ></i>

                                        <h5>
                                            No tasks found
                                        </h5>

                                        <p class="text-muted mb-0">
                                            Try changing your search or filters.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if($tasks->hasPages())

                    <div class="d-flex justify-content-center mt-4">

                        {{ $tasks->links() }}

                    </div>

                @endif


                {{-- Result Count --}}
                @if($tasks->total() > 0)

                    <div class="text-muted mt-3">

                        Showing
                        <strong>{{ $tasks->firstItem() }}</strong>
                        to
                        <strong>{{ $tasks->lastItem() }}</strong>
                        of
                        <strong>{{ $tasks->total() }}</strong>
                        tasks

                    </div>

                @else

                    <div class="text-muted mt-3">
                        No matching tasks found.
                    </div>

                @endif

            </div>

        </div>

    </form>


    {{-- JavaScript --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const selectAll = document.getElementById('selectAll');

            const checkboxes = document.querySelectorAll('.task-checkbox');

            const bulkActions = document.getElementById('bulkActions');

            const selectedCount = document.getElementById('selectedCount');


            function updateBulkActions() {

                const selected = document.querySelectorAll(
                    '.task-checkbox:checked'
                );

                const count = selected.length;

                selectedCount.textContent = count;

                if (count > 0) {

                    bulkActions.style.setProperty(
                        'display',
                        'flex',
                        'important'
                    );

                } else {

                    bulkActions.style.setProperty(
                        'display',
                        'none',
                        'important'
                    );

                }

                selectAll.checked =
                    checkboxes.length > 0 &&
                    count === checkboxes.length;

            }


            selectAll.addEventListener('change', function () {

                checkboxes.forEach(function (checkbox) {

                    checkbox.checked = selectAll.checked;

                });

                updateBulkActions();

            });


            checkboxes.forEach(function (checkbox) {

                checkbox.addEventListener('change', function () {

                    updateBulkActions();

                });

            });

        });


        function deleteSingleTask(taskId) {

            if (!confirm('Are you sure you want to delete this task?')) {
                return;
            }

            const form = document.createElement('form');

            form.method = 'POST';

            form.action = "{{ url('/tasks') }}/" + taskId;

            const csrf = document.createElement('input');

            csrf.type = 'hidden';

            csrf.name = '_token';

            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);


            const method = document.createElement('input');

            method.type = 'hidden';

            method.name = '_method';

            method.value = 'DELETE';

            form.appendChild(method);


            document.body.appendChild(form);

            form.submit();

        }

    </script>

@endsection