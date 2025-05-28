<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Article;
use App\Livewire\Pages\Post;
use App\Livewire\DocBot;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\AiDrawController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Profile\AvatarController;


// Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
// Route::get("/", Home::class)->name('home');
Route::get('/', function ()
{
    return redirect('/'.config('app.fallback_locale'));
});


Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function ()
{
    Route::get('/', Home::class)->name('home');
    Route::get("/articles/{articles:slug}", Article::class)->name('article.show');
    Route::get("/{type}/{menu:slug}", Post::class)->name('post.show');

    Route::get('mobile', DocBot::class)->name('mobile.index');
    Route::post('mobile', DocBot::class)->name('mobile.store');



    Route::resource('chirps', ChirpController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);


//Note
// Route::get('/note', [NoteController::class, 'index'])->name('note.index');
// Route::get('/note/create', [NoteController::class, 'create'])->name('note.create');
// Route::post('/note', [NoteController::class, 'store'])->name('note.store');
// Route::get('/note/{id}', [NoteController::class, 'show'])->name('note.show');
// Route::get('/note/{id}/edit', [NoteController::class, 'edit'])->name('note.edit');
// Route::put('/note/{id}', [NoteController::class, 'update'])->name('note.update');
// Route::delete('/note/{id}', [NoteController::class, 'destory'])->name('note.destory');
Route::resource('note', NoteController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);


    //Chat GPT
    Route::get('openai', [AiDrawController::class, 'index'])->name('openai.index');
    Route::post('openai', [AiDrawController::class, 'store'])->name('openai.store');

    //OpenAI
    Route::get('gpt', [ChatController::class, 'index'])->name('gpt.index');
    Route::post('gpt', [ChatController::class, 'store'])->name('gpt.store');


    // backstage
    // Route::middleware(['auth', 'verified'])->prefix('backstage')->name('admin.')->group(function () {
    //     Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    //     Route::get('/post', [Post::class, 'index'])->name('post');
    // });
});



Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/logout', [LogoutController::class, 'web_logout'])
    ->middleware(['web'])
    ->name('logout');
Route::post('/admin/logout', [LogoutController::class, 'admin_logout'])
    ->middleware(['web'])
    ->name('filament.admin.auth.logout');


require __DIR__.'/auth.php';