<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index() {
        try {
            $students = Student::with('section')->get();
            return view('student.index', compact('students'));
        } catch (\Exception $e) {
            Log::error('Error fetching students: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load students list.');
        }
    }

    public function create() {
        try {
            $sections = Section::all();
            return view('student.create', compact('sections'));
        } catch (\Exception $e) {
            Log::error('Error loading student create form: ' . $e->getMessage());
            return redirect()->route('students.index')->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'student_id' => 'required|unique:students,student_id|max:10',
                'lname' => 'required|string|max:150',
                'fname' => 'required|string|max:150',
                'mname' => 'nullable|string|max:150',
                'email' => 'required|email|max:150|unique:students,email',
                'contact' => 'required|max:20',
                'section_id' => 'required|exists:sections,id'
            ]);

            Student::create($request->all());

            return redirect()->route('students.index')
                ->with('success', 'Student created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating student: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create student. Please try again.')
                ->withInput();
        }
    }

    public function edit(Student $student) {
        try {
            $sections = Section::all();
            return view('student.edit', compact('student', 'sections'));
        } catch (\Exception $e) {
            Log::error('Error loading student edit form: ' . $e->getMessage());
            return redirect()->route('students.index')->with('error', 'Failed to load edit form.');
        }
    }

    public function update(Request $request, Student $student) {
        try {
            $request->validate([
                'student_id' => 'required|max:10|unique:students,student_id,' . $student->id,
                'lname' => 'required|string|max:150',
                'fname' => 'required|string|max:150',
                'mname' => 'nullable|string|max:150',
                'email' => 'required|email|max:150|unique:students,email,' . $student->id,
                'contact' => 'required|max:20',
                'section_id' => 'required|exists:sections,id'
            ]);

            $student->update($request->all());

            return redirect()->route('students.index')
                ->with('success', 'Student updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating student: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update student. Please try again.')
                ->withInput();
        }
    }

    public function delete(Student $student) {
        try {
            $student->delete();

            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting student: ' . $e->getMessage());
            return redirect()->route('students.index')
                ->with('error', 'Failed to delete student. Please try again.');
        }
    }

    public function show(Student $student) {
        try {
            $student->load('section'); // eager load section
            return view('student.show', compact('student'));
        } catch (\Exception $e) {
            Log::error('Error showing student: ' . $e->getMessage());
            return redirect()->route('students.index')->with('error', 'Failed to load student details.');
        }
    }

    public function moveForm(Student $student) {
        try {
            $sections = Section::all();
            return view('student.move', compact('student', 'sections'));
        } catch (\Exception $e) {
            Log::error('Error loading move student form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load move student form.');
        }
    }

    public function move(Request $request, Student $student) {
        try {
            $request->validate([
                'section_id' => 'required|exists:sections,id'
            ]);

            $student->update([
                'section_id' => $request->section_id
            ]);

            return redirect()->route('sections.show', $request->section_id)
                ->with('success', 'Student moved successfully!');
        } catch (\Exception $e) {
            Log::error('Error moving student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to move student. Please try again.');
        }
    }


}
