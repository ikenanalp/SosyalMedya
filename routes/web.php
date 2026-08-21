<?php

use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserBanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified','banned'
])->group(function () {

    Route::get('/dashboard', [PostController::class, 'showMainPage'])->name('profile');


// Sayfa Yönlendirme Rootları

    Route::get('/mainpage', [PostController::class, 'showMainPage'])->name('panel.user.showMainPage');
    Route::get('/profile', [PostController::class, 'showProfilePage'])->name('panel.user.showProfilePage');
    Route::get('/createpost', [PostController::class, 'showCreatePostPage'])->name('panel.user.showCreatePost');
    Route::get('/finduser', [UserController::class, 'showFindUserPage'])->name('panel.user.showFindUserPage');

//

// Profil Düzenleme (Avatar + Biyografi)
// Not: '/profile/{user}' route'undan ÖNCE tanımlanmalı, yoksa Laravel 'edit' kelimesini
// bir kullanıcı id/username'i sanıp o route'a yönlendirmeye çalışır.

    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('panel.user.editProfile');
    Route::post('/profile/edit', [ProfileController::class, 'updateProfile'])->name('panel.user.updateProfile');

//

        Route::get('/profile/{user}', [UserController::class, 'userProfilePage'])->name('panel.user.showProfile'); //Aranan kullanıcı profili gösterme
    Route::get('/profile/{user}/followers', [UserController::class, 'followersList'])->name('panel.user.followers');
    Route::get('/profile/{user}/following', [UserController::class, 'followingList'])->name('panel.user.following');
    Route::get('/myfollowingpage', [PostController::class, 'showMyFollowingPage'])->name('panel.user.showMyFollowingPage');

//

// Post Oluşturma ve Silme

    Route::post('/createpost', [postController::class, 'createPost'])->name('panel.user.createPost');
    Route::delete('/deletepost/{id}', [postController::class, 'deletePost'])->name('panel.user.deletePost');

//

// Yorum Ekleme Ve Silme

    Route::post('/createcomment/{id}', [CommentController::class, 'createComment'])->name('user.createComment');
    Route::delete('/deletecomment/{id}', [CommentController::class, 'deleteComment'])->name('user.deleteComment');

//

//Like Sistemi

    Route::post('/userlike/{id}', [LikeController::class, 'userLike'])->name('user.likeSystem');

//

//Follow Sistemi

    Route::post('/togglefollow/{id}', [FollowerController::class, 'toggleFollow'])->name('user.toggleFollow');

//

// Kullanıcı Şikayet Sistemis

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');

//

    Route::middleware([
        'admin',
    ])->group(function () {

//Admin dashboard

        Route::get('/admin/dashboard', [DashboardController::class, 'showAdminDashboard'])->name('admin.dashboard');
        Route::get('/posts/rejected', [DashboardController::class, 'showRejectedPosts'])->name('show.posts.rejected');
        Route::get('/posts/approved', [DashboardController::class, 'showApprovedPosts'])->name('show.posts.approved');

//

// Post Onay Sistemi

        Route::get('/posts/pending', [DashboardController::class, 'pendingPosts'])->name('posts.pending');
        Route::post('/posts/{post}/approve', [DashboardController::class, 'approvedPosts'])->name('posts.approve');
        Route::post('/posts/{post}/reject', [DashboardController::class, 'rejectedPosts'])->name('posts.reject');

//

// Kullanıcı Ban Sistemi

        Route::get('/users', [UserBanController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/ban', [UserBanController::class, 'banUsers'])->name('users.ban');
        Route::post('/users/{user}/unban', [UserBanController::class, 'unbanUsers'])->name('users.unban');

//


// Admin Feedback Sistemi

        Route::get('/admin/feedback', [AdminFeedbackController::class, 'index'])->name('admin.feedback.index');
        Route::get('/admin/feedback/{feedback}', [AdminFeedbackController::class, 'show'])->name('admin.feedback.show');
        Route::patch('/admin/feedback/{feedback}/respond', [AdminFeedbackController::class, 'respond'])->name('admin.feedback.respond');

//




    });

});
