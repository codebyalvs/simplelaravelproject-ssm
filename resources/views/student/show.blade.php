@extends('layouts.app')

@section('title', 'View Student')

@section('content')

<div class="page-header">
    <h1>Student Details</h1>
    <div class="page-actions">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-secondary">
            Edit Student
        </a>
        <a href="{{ route('students.index') }}" class="btn btn-outline">
            Back to Students
        </a>
    </div>
</div>

<div class="student-details">
    <ul class="detail-list">
        <li>
            <strong>Student ID:</strong>
            <span>{{ $student->student_id }}</span>
        </li>
        <li>
            <strong>Full Name:</strong>
            <span>{{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</span>
        </li>
        <li>
            <strong>Email:</strong>
            <span>
                <a href="mailto:{{ $student->email }}" class="text-primary">
                    {{ $student->email }}
                </a>
            </span>
        </li>
        <li>
            <strong>Contact:</strong>
            <span>{{ $student->contact }}</span>
        </li>
        <li>
            <strong>Section:</strong>
            <span>
                @if($student->section)
                    <span class="badge">{{ $student->section->name }}</span>
                @else
                    <span class="text-secondary">N/A</span>
                @endif
            </span>
        </li>
        <li>
            <strong>Date Added:</strong>
            <span>{{ $student->created_at->format('F j, Y g:i A') }}</span>
        </li>
        @if($student->updated_at != $student->created_at)
        <li>
            <strong>Last Updated:</strong>
            <span>{{ $student->updated_at->format('F j, Y g:i A') }}</span>
        </li>
        @endif
    </ul>
</div>

@endsection

@push('styles')
<style>
.text-primary {
    color: var(--primary);
    text-decoration: none;
}

.text-primary:hover {
    text-decoration: underline;
}

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
