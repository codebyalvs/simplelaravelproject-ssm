<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;




Route::get('/', function () {
    return view('section.index');
});

// TABLE SECTIONS
Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');

// CREATE SECTIONS
Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');

// UPDATE SECTIONS
Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');

// DELETE SECTIONS
Route::delete('/sections/{section}', [SectionController::class, 'delete'])->name('sections.delete');

// SHOW SECTION
Route::get('/sections/{section}', [SectionController::class, 'show'])->name('sections.show');





// TABLE STUDENTS
Route::get('/students', [StudentController::class, 'index'])->name('students.index');

// CREATE STUDENTS
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

// UPDATE STUDENTS
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

// DELETE STUDENTS
Route::delete('/students/{student}', [StudentController::class, 'delete'])->name('students.delete');

// SHOW STUDENT
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

// MOVE STUDENT TO ANOTHER SECTION
Route::get('/students/{student}/move', [StudentController::class, 'moveForm'])->name('students.moveForm');
Route::put('/students/{student}/move', [StudentController::class, 'move'])->name('students.move');

