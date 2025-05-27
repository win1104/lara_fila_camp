<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\Article;
use App\Livewire\Pages\Post;
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
    // Route::get("/post/{menu:slug}", Post::class)->name('post.show');
    // Route::get("/list/{menu:slug}", Post::class)->name('list.show');

    // Route::resource('note', NoteController::class);
    // Route::get('/teams', [PostController::class, 'index'])->name('about.team');
    // Route::get('/organization', [PostSwitchController::class, 'index'])->name('about.organization');
    // Route::get('/events', [EventsController::class, 'index'])->name('about.events');
    // Route::get('/news', [NewsController::class, 'index'])->name('news.latest');
    // Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
    // Route::get('/notes', [NotesController::class, 'index'])->name('sermon.notes');
    // Route::get('/notes/{id}', [NotesController::class, 'show'])->name('notes.show');
    // Route::get('/video', [videoController::class, 'index'])->name('sermon.video');
    // Route::get('/video/{id}', [videoController::class, 'show'])->name('videos.show');
    // Route::get('/media', [mediaController::class, 'index'])->name('life.media');
    // Route::get('/media/{id}', [mediaController::class, 'show'])->name('media.show');


    // backstage
    // Route::middleware(['auth', 'verified'])->prefix('backstage')->name('admin.')->group(function () {
    //     Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    //     Route::get('/post', [Post::class, 'index'])->name('post');
    // });
});





// Route::get("/articles/{articles:slug}", Article::class)->name('article.show');


// Route::view('/home', 'home');
// Route::middleware([
//         'post',
//         // 其他中間件...
//     ])
//     ->prefix('admin')
//     ->group(function () {
//         // 自定義路由...
//         Route::get('/articles/2/edit', [ProfileController::class, 'edit'])->name('post.edit');
//     });




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



