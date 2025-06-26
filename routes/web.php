<?php

use App\Livewire\DocBot;
use App\Livewire\ChatWidget;
use Illuminate\Http\Request;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Post;
use App\Livewire\Pages\Product;
use App\Livewire\Pages\Article;
use App\Livewire\Pages\Aiing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\AiDrawController;
use App\Http\Controllers\LogoutController;
// use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Models\Chat_assistant;


// Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
// Route::get("/", Home::class)->name('home');
// Route::get('/', function ()
// {
//     return redirect('/'.config('app.fallback_locale'));
// });
Route::get('/aiing', Aiing::class);

// 認證相關路由
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 密碼更新相關路由
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // 郵件驗證相關路由
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::post('/logout', [LogoutController::class, 'web_logout'])
    ->middleware(['web'])
    ->name('logout');
Route::post('/admin/logout', [LogoutController::class, 'admin_logout'])
    ->middleware(['web'])
    ->name('filament.admin.auth.logout');


// 需要語系的路由
Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function ()
{
    Route::get('/', Home::class)->name('home');
    Route::get("/articles/{articles:slug}", Article::class)->name('article.show');

    Route::get('mobile', DocBot::class)->name('mobile.index');
    Route::post('mobile', DocBot::class)->name('mobile.store');

    Route::get("/products", Product::class)->name('product.show');
    Route::get("/products/{product:slug}", Product::class)->name('product.detail');

    Route::get("/{type}/{menu:slug}", Post::class)->name('post.show');
    Route::get("/{type}/{menu:slug}/{post:slug}", Post::class)->name('post.detail');



    // Route::get('/products', function () {
    //     return view('products.index'); // 直接導向 Blade 視圖，其中嵌入了 Livewire 元件

    Route::resource('chirps', ChirpController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);

    Route::resource('note', NoteController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);

    //Chat GPT
    Route::get('openai', [AiDrawController::class, 'index'])->name('openai.index');
    Route::post('openai', [AiDrawController::class, 'store'])->name('openai.store');

    //OpenAI
    Route::get('gpt', [ChatController::class, 'index'])->name('gpt.index');
    Route::post('gpt', [ChatController::class, 'store'])->name('gpt.store');

    Route::get('assistant_ustech', ChatWidget::class);
    Route::get('assistant', ChatWidget::class);

    Route::post('/embed/{embed:slug}', [EmbedController::class, 'embed.show'])
        ->name('embed');


    // routes/web.php
    // Route::get('/assistant_ustech', function (Request $request) {
    //     $client = $request->get('client', 'default');
    //     $open = $request->get('open', '1') === 'true';
    //     $chats = Chat_assistant::where('client', $client)->with('user')->latest()->take(5)->get()->reverse();
    //     return view('livewire.chat-widget', compact('client', 'open', 'chats'));
    // });


});
