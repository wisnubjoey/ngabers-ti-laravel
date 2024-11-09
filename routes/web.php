<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WelcomeController;
use App\Models\Post;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SearchController;

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

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome')->middleware('guest');

Route::get('/search', [SearchController::class, 'search'])->name('search');

// Auth required routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'posts' => Post::with('user')->latest()->get()
        ]);
    })->name('dashboard');

    // Profile routes
  // Profile routes
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile/edit', 'edit')->name('profile.edit');
    Route::put('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
    Route::get('/profile/{user}', 'show')->name('profile.show');    // Parameter route selalu di paling bawah
});

    // Post routes
    Route::controller(PostController::class)->group(function () {
        Route::get('/posts', 'index')->name('posts.index');
        Route::get('/posts/create', 'create')->name('posts.create');
        Route::post('/posts', 'store')->name('posts.store');
        Route::get('/posts/{post}', 'show')->name('posts.show');
        Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
        Route::put('/posts/{post}', 'update')->name('posts.update');
        Route::delete('/posts/{post}', 'destroy')->name('posts.destroy');
        Route::post('/posts/{post}/like', 'toggleLike')->name('posts.like');
    });

    // Comment routes
    Route::controller(CommentController::class)->group(function () {
        Route::post('/posts/{post}/comments', 'store')->name('comments.store');
        Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::post('/events/{event}/join', [EventController::class, 'toggleJoin'])->name('events.join');
        Route::post('/events/{event}/complete', [EventController::class, 'markAsComplete'])->name('events.complete');
    });
});

require __DIR__.'/auth.php';