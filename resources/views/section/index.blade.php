@extends('layouts.app')

@section('title', 'Section Management')

@section('content')

<div class="page-header">
    <h1>Section List</h1>
    <div class="page-actions">
        <a href="{{ route('sections.create') }}" class="btn btn-primary">
            Add New Section
        </a>
    </div>
</div>

@if($sections->count() > 0)
    <div class="table-container">
        <table class="table section-table">
            <thead>
                <tr>
                    <th>Section Name</th>
                    <th>Student Count</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td>
                            <strong>{{ $section->name }}</strong>
                        </td>
                        <td>
                            <span class="student-count">
                                {{ $section->students->count() }} students
                            </span>
                        </td>
                        <td>
                            {{ $section->created_at->format('M j, Y') }}
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('sections.show', $section) }}" class="btn btn-sm btn-outline">
                                    View
                                </a>
                                <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-secondary">
                                    Edit
                                </a>
                                <form action="{{ route('sections.delete', $section) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
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
        <h3>No sections found</h3>
        <p>Get started by creating your first section to organize students.</p>
        <a href="{{ route('sections.create') }}" class="btn btn-primary">
            Create First Section
        </a>
    </div>
@endif

@endsection

@push('styles')
<style>
.student-count {
    color: var(--secondary);
    font-size: 0.875rem;
}
</style>
@endpush
