@extends('layouts.app')

@section('title', 'Student Management')

@section('content')

<div class="page-header">
    <h1>Student List</h1>
    <div class="page-actions">
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            Add New Student
        </a>
    </div>
</div>

@if($students->count() > 0)
    <div class="table-container">
        <table class="table student-table">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td><strong>{{ $student->student_id }}</strong></td>
                        <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->contact }}</td>
                        <td>
                            @if($student->section)
                                <span class="badge">{{ $student->section->name }}</span>
                            @else
                                <span class="text-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline">
                                    View
                                </a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-secondary">
                                    Edit
                                </a>
                                <form action="{{ route('students.delete', $student) }}" method="POST" style="display:inline;">
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
        <h3>No students found</h3>
        <p>Get started by adding your first student to the system.</p>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            Add New Student
        </a>
    </div>
@endif

@endsection

@push('styles')
<style>
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
    background-color: var(--primary);
    color: white;
    border-radius: 9999px;
}

.text-secondary {
    color: var(--secondary);
    font-style: italic;
}
</style>
@endpush
