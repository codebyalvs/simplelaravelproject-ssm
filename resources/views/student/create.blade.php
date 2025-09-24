@extends('layouts.app')

@section('title', 'Add Student')

@section('content')

<div class="page-header">
    <h1>Add New Student</h1>
</div>

@if ($errors->any())
    <div class="error-box">
        <h3>Please fix the following errors:</h3>
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="student_id" class="form-label">Student Number</label>
                <input
                    type="text"
                    id="student_id"
                    name="student_id"
                    value="{{ old('student_id') }}"
                    placeholder="Enter student number"
                    class="form-input @error('student_id') is-invalid @enderror"
                    required
                >
                @error('student_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="fname" class="form-label">First Name</label>
                <input
                    type="text"
                    id="fname"
                    name="fname"
                    value="{{ old('fname') }}"
                    placeholder="Enter first name"
                    class="form-input @error('fname') is-invalid @enderror"
                    required
                >
                @error('fname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mname" class="form-label">Middle Initial</label>
                <input
                    type="text"
                    id="mname"
                    name="mname"
                    value="{{ old('mname') }}"
                    placeholder="Enter middle initial (optional)"
                    class="form-input @error('mname') is-invalid @enderror"
                >
                @error('mname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lname" class="form-label">Last Name</label>
                <input
                    type="text"
                    id="lname"
                    name="lname"
                    value="{{ old('lname') }}"
                    placeholder="Enter last name"
                    class="form-input @error('lname') is-invalid @enderror"
                    required
                >
                @error('lname')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="section_id" class="form-label">Section</label>
                <select
                    id="section_id"
                    name="section_id"
                    class="form-select @error('section_id') is-invalid @enderror"
                    required
                >
                    <option value="">Select Section</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
                @error('section_id')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter email address"
                    class="form-input @error('email') is-invalid @enderror"
                    required
                >
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact" class="form-label">Contact Number</label>
                <input
                    type="text"
                    id="contact"
                    name="contact"
                    value="{{ old('contact') }}"
                    placeholder="Enter contact number"
                    class="form-input @error('contact') is-invalid @enderror"
                    required
                >
                @error('contact')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    Save Student
                </button>
                <a href="{{ route('students.index') }}" class="btn btn-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
