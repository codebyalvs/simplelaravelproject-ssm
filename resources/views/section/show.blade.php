@extends('layouts.app')

@section('title', 'View Section')

@section('content')

<div class="page-header">
    <h1>Section: {{ $section->name }}</h1>
    <div class="page-actions">
        <a href="{{ route('sections.edit', $section) }}" class="btn btn-secondary">
            Edit Section
        </a>
        <a href="{{ route('sections.index') }}" class="btn btn-outline">
            Back to Sections
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Section Overview</h3>
    </div>
    <div class="card-body">
        <ul class="detail-list">
            <li>
                <strong>Section Name:</strong>
                <span>{{ $section->name }}</span>
            </li>
            <li>
                <strong>Total Students:</strong>
                <span class="student-count-badge">{{ $section->students->count() }}</span>
            </li>
            <li>
                <strong>Created Date:</strong>
                <span>{{ $section->created_at->format('F j, Y g:i A') }}</span>
            </li>
            @if($section->updated_at != $section->created_at)
            <li>
                <strong>Last Updated:</strong>
                <span>{{ $section->updated_at->format('F j, Y g:i A') }}</span>
            </li>
            @endif
        </ul>
    </div>
</div>

@if($section->students->count() > 0)
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3>Students in this Section</h3>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($section->students as $student)
                            <tr>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                                <td>
                                    <a href="mailto:{{ $student->email }}" class="text-primary">
                                        {{ $student->email }}
                                    </a>
                                </td>
                                <td>{{ $student->contact }}</td>
                                <td>
                                    <div class="table-actions">
                                        {{-- <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline">
                                            View
                                        </a> --}}
                                        <a href="{{ route('students.moveForm', $student) }}" class="btn btn-sm btn-secondary">
                                            Move
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="empty-state" style="margin-top: 2rem;">
        <h3>No students assigned</h3>
        <p>This section doesn't have any students yet. Students can be assigned when creating or editing student records.</p>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            Add New Student
        </a>
    </div>
@endif

@endsection

@push('styles')
<style>
.student-count-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    background-color: var(--primary);
    color: white;
    border-radius: 9999px;
}

.text-primary {
    color: var(--primary);
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}
</style>
@endpush
