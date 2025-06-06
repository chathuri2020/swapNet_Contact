<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');


    // category
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category-create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category-store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/{contact}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{contact}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category-destroy/{contact}', [CategoryController::class, 'destroy'])->name('category.destroy');




      // contact
      Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
      Route::get('contact-create', [ContactController::class, 'create'])->name('contact.create');
      Route::post('contact-store', [ContactController::class, 'store'])->name('contact.store');
      Route::get('contact/{contact}', [ContactController::class, 'edit'])->name('contact.edit');
      Route::put('contact/{contact}', [ContactController::class, 'update'])->name('contact.update');
      Route::delete('contact-destroy/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');


    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('change-password', [ProfileController::class, 'password'])->name('password.index');
    Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::resource('users', UserController::class);
    Route::get('user-ban-unban/{id}/{status}', 'UserController@banUnban')->name('user.banUnban');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
