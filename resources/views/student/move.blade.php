@extends('layouts.app')

@section('title', 'Move Student')

@section('content')

<div class="page-header">
    <h1>Move Student</h1>
</div>

<div class="card">
    <div class="card-header">
        <h3>Transfer Student to New Section</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <p><strong>Student:</strong> {{ $student->lname }}, {{ $student->fname }} {{ $student->mname }}</p>
            <p><strong>Current Section:</strong>
                @if($student->section)
                    <span class="badge">{{ $student->section->name }}</span>
                @else
                    <span class="text-secondary">N/A</span>
                @endif
            </p>
        </div>

        <form action="{{ route('students.move', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="section_id" class="form-label">Select New Section</label>
                <select
                    name="section_id"
                    id="section_id"
                    class="form-select @error('section_id') is-invalid @enderror"
                    required
                >
                    <option value="">-- Choose Section --</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ $student->section_id == $section->id ? 'disabled' : '' }}>
                            {{ $section->name }}
                            @if($student->section_id == $section->id)
                                (Current Section)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('section_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    Move Student
                </button>
                <a href="{{ route('sections.show', $student->section_id) }}" class="btn btn-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

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

option[disabled] {
    opacity: 0.6;
    font-style: italic;
}
</style>
@endpush
