<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\BuilderController as AdminBuilderController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PostCategoryController as AdminPostCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes — fully dynamic CMS (Pages + Blocks, Blog, Menus, Settings)
|--------------------------------------------------------------------------
*/

// ---------------- Public frontend ----------------
Route::get('/', [FrontPageController::class, 'home'])->name('home');

// Dynamic blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show')->where('slug', '[A-Za-z0-9\-]+');

// Dynamic page (explicit prefix kept for backward-compatible links)
Route::get('/page/{slug}', [FrontPageController::class, 'show'])->name('page.show');

// ---------------- Auth ----------------
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

// ---------------- Admin (auth) ----------------
Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function () {

        // Pages + visual page builder
        Route::get('/pages', [AdminPageController::class, 'index'])->name('admin.pages.index');
        Route::get('/pages/create', [AdminPageController::class, 'create'])->name('admin.pages.create');
        Route::post('/pages', [AdminPageController::class, 'store'])->name('admin.pages.store');
        Route::get('/pages/{id}/edit', [AdminPageController::class, 'edit'])->name('admin.pages.edit');
        Route::post('/pages/{id}', [AdminPageController::class, 'update'])->name('admin.pages.update');
        Route::get('/pages/{id}/delete', [AdminPageController::class, 'destroy'])->name('admin.pages.destroy');
        Route::get('/pages/{id}/builder', [AdminBuilderController::class, 'editor'])->name('admin.pages.builder');
        Route::post('/pages/{id}/builder', [AdminBuilderController::class, 'save'])->name('admin.pages.builder.save');
        Route::post('/builder/preview', [AdminBuilderController::class, 'preview'])->name('admin.builder.preview');
        Route::post('/builder/upload', [AdminBuilderController::class, 'upload'])->name('admin.builder.upload');

        // Menus (nested drag & drop)
        Route::get('/menus', [AdminMenuController::class, 'index'])->name('admin.menus.index');
        Route::get('/menus/create', [AdminMenuController::class, 'create'])->name('admin.menus.create');
        Route::post('/menus', [AdminMenuController::class, 'store'])->name('admin.menus.store');
        Route::get('/menus/{id}/edit', [AdminMenuController::class, 'edit'])->name('admin.menus.edit');
        Route::post('/menus/{id}', [AdminMenuController::class, 'update'])->name('admin.menus.update');
        Route::get('/menus/{id}/delete', [AdminMenuController::class, 'destroy'])->name('admin.menus.destroy');
        Route::post('/menus/{menu}/reorder', [AdminMenuController::class, 'reorder'])->name('admin.menus.reorder');
        Route::post('/menus/{menu}/items', [AdminMenuController::class, 'storeItem'])->name('admin.menus.items.store');
        Route::post('/menu-items/{item}', [AdminMenuController::class, 'updateItem'])->name('admin.menus.items.update');
        Route::get('/menu-items/{item}/delete', [AdminMenuController::class, 'destroyItem'])->name('admin.menus.items.destroy');

        // Blog posts + categories
        Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
        Route::get('/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
        Route::post('/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
        Route::get('/posts/{id}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
        Route::post('/posts/{id}', [AdminPostController::class, 'update'])->name('admin.posts.update');
        Route::get('/posts/{id}/delete', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
        Route::get('/post-categories', [AdminPostCategoryController::class, 'index'])->name('admin.post_categories.index');
        Route::post('/post-categories', [AdminPostCategoryController::class, 'store'])->name('admin.post_categories.store');
        Route::post('/post-categories/{id}', [AdminPostCategoryController::class, 'update'])->name('admin.post_categories.update');
        Route::get('/post-categories/{id}/delete', [AdminPostCategoryController::class, 'destroy'])->name('admin.post_categories.destroy');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::get('/users/{id}/delete', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        // Site settings (header / footer / branding / social / SEO)
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    });
});

// ---------------- Catch-all dynamic page (MUST be last) ----------------
Route::get('/{slug}', [FrontPageController::class, 'show'])
    ->name('page.slug')
    ->where('slug', '[A-Za-z0-9\-]+');
