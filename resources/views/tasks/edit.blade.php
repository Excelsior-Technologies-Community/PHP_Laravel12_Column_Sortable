@extends('layouts.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Tasks
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h2>Edit Task</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Title *</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $task->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="priority" class="form-label">Priority *</label>
                    <select class="form-select @error('priority') is-invalid @enderror" 
                            id="priority" name="priority" required>
                        <option value="Low" {{ (old('priority', $task->priority) == 'Low') ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ (old('priority', $task->priority) == 'Medium') ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ (old('priority', $task->priority) == 'High') ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="Pending" {{ (old('status', $task->status) == 'Pending') ? 'selected' : '' }}>Pending</option>
                        <option value="In Progress" {{ (old('status', $task->status) == 'In Progress') ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ (old('status', $task->status) == 'Completed') ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                           id="due_date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection