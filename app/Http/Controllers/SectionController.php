<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function index() {
        try {
            $sections = Section::all();
            return view('section.index', compact('sections'));
        } catch (\Exception $e) {
            Log::error('Error fetching sections: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load sections list.');
        }
    }

    public function create() {
        try {
            return view('section.create');
        } catch (\Exception $e) {
            Log::error('Error loading section create form: ' . $e->getMessage());
            return redirect()->route('sections.index')->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required|unique:sections,name|string|max:255'
            ]);

            Section::create($request->all());

            return redirect()->route('sections.index')
                ->with('success', 'Section created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating section: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create section. Please try again.')
                ->withInput();
        }
    }

    public function edit(Section $section) {
        try {
            return view('section.edit', compact('section'));
        } catch (\Exception $e) {
            Log::error('Error loading section edit form: ' . $e->getMessage());
            return redirect()->route('sections.index')->with('error', 'Failed to load edit form.');
        }
    }

    public function update(Request $request, Section $section) {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('sections')->ignore($section->id)
                ]
            ]);

            $section->update($request->all());

            return redirect()->route('sections.index')
                ->with('success', 'Section updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating section: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update section. Please try again.')
                ->withInput();
        }
    }

    public function delete(Section $section) {
        try {
            // Check if section has students before deleting
            if ($section->students()->count() > 0) {
                return redirect()->route('sections.index')
                    ->with('error', 'Cannot delete section. There are students assigned to this section.');
            }

            $section->delete();

            return redirect()->route('sections.index')
                ->with('success', 'Section deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting section: ' . $e->getMessage());
            return redirect()->route('sections.index')
                ->with('error', 'Failed to delete section. Please try again.');
        }
    }

    public function show(Section $section) {
        try {
            // eager load students
            $section->load('students');
            return view('section.show', compact('section'));
        } catch (\Exception $e) {
            Log::error('Error showing section: ' . $e->getMessage());
            return redirect()->route('sections.index')->with('error', 'Failed to load section details.');
        }
    }



}
