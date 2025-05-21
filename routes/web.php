<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\AiDrawController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Profile\AvatarController;
use App\Livewire\DocBot;


// Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
Route::get("/", Home::class)->name('home');
Route::get("/articles/{articles:slug}", Article::class)->name('article.show');

Route::get('/mobile',DocBot::class)->name('mobile');


// Route::view('/home', 'home');
Route::middleware([
        'post',
        // 其他中間件...
    ])
    ->prefix('admin')
    ->group(function () {
        // 自定義路由...
        Route::get('/articles/2/edit', [ProfileController::class, 'edit'])->name('post.edit');
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


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);


//OpenAI
Route::resource('gpt', ChatController::class)
    ->only(['index', 'store']);

//Chat GPT
Route::resource('openai', AiDrawController::class)
    ->only(['index', 'store']);

require __DIR__.'/auth.php';


//Note
// Route::get('/note', [NoteController::class, 'index'])->name('note.index');
// Route::get('/note/create', [NoteController::class, 'create'])->name('note.create');
// Route::post('/note', [NoteController::class, 'store'])->name('note.store');
// Route::get('/note/{id}', [NoteController::class, 'show'])->name('note.show');
// Route::get('/note/{id}/edit', [NoteController::class, 'edit'])->name('note.edit');
// Route::put('/note/{id}', [NoteController::class, 'update'])->name('note.update');
// Route::delete('/note/{id}', [NoteController::class, 'destory'])->name('note.destory');
Route::resource('note', NoteController::class);



