<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard',[PostController::class,'showMainPage'])->name('profile'); });

// Sayfa Yönlendirme Rootları

Route::get('/mainpage',[PostController::class,'showMainPage'])->name('panel.user.showMainPage');
Route::get('/profile',[PostController::class,'showProfilePage'])->name('panel.user.showProfilePage');
Route::get('/createpost',[PostController::class,'showCreatePostPage'])->name('panel.user.showCreatePost');
Route::get('/finduser',[UserController::class,'showFindUserPage'])->name('panel.user.showFindUserPage');
Route::get('/profile/{user}',[UserController::class,'userProfilePage'])->name('panel.user.showProfile'); //Aranan kullanıcı profili gösterme
Route::get('/myfollowingpage',[PostController::class,'showMyFollowingPage'])->name('panel.user.showMyFollowingPage');

//

// Post Oluşturma ve Silme

Route::post('/createpost',[postController::class,'createPost'])->name('panel.user.createPost');
Route::delete('/deletepost/{id}',[postController::class,'deletePost'])->name('panel.user.deletePost');

//

// Yorum Ekleme Ve Silme

Route::post('/createcomment/{id}',[CommentController::class,'createComment'])->name('user.createComment');
Route::delete('/deletecomment/{id}',[CommentController::class,'deleteComment'])->name('user.deleteComment');

//

//Like Sistemi

Route::post('/userlike/{id}', [LikeController::class, 'userLike'])->name('user.likeSystem');

//

//Follow Sistemi

Route::post('/togglefollow/{id}', [FollowerController::class, 'toggleFollow'])->name('user.toggleFollow');

//

