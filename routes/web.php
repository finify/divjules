<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/ 
 Volt::route('/', 'home.index')->name('home.index');
Volt::route('/about', 'home.about')->name('home.about');
Volt::route('/contact', 'home.contact')->name('home.contact');
#blog routes
Volt::route('/blog', 'home.blog')->name('home.blog');
Volt::route('/blog/{slug}', 'blog.show')->name('blog.show');
#blog routes end

#courses routes
Volt::route('/courses', 'home.courses')->name('home.courses');
Volt::route('/courses/{course:slug}', 'courses.show')->name('courses.show');
#courses routes end

#universities routes
Volt::route('/universities', 'home.universities')->name('home.universities');
Volt::route('/universities/{university:slug}', 'universities.show')->name('universities.show');
#universities routes end

#application routes
Volt::route('/apply', 'home.apply')->name('home.apply');
Volt::route('/submit-review', 'home.submit-review')->name('home.submit-review');
Volt::route('/application/track', 'application.track')->name('application.track');

// Admin route for document download
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/application/document/{document}/download', function ($documentId) {
        $document = \App\Models\ApplicationDocument::findOrFail($documentId);

        if (!\Illuminate\Support\Facades\Storage::exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return \Illuminate\Support\Facades\Storage::download(
            $document->file_path,
            $document->file_name
        );
    })->name('admin.application.document.download');
});
#application routes end

