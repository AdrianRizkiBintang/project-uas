<?php

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
use App\Http\Controllers\ProfileController;
>>>>>>> cd1aac3ff3eb328e01c7ec3a7a1c81eba9d6d37f
<<<<<<< HEAD
>>>>>>> friend-repo/main
=======
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
>>>>>>> 3abcfe4cede430b0b2dc1e5e423bb33d0da8224f
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
>>>>>>> cd1aac3ff3eb328e01c7ec3a7a1c81eba9d6d37f
<<<<<<< HEAD
>>>>>>> friend-repo/main
=======
>>>>>>> 43b70fe15192ffe77de4cb776a49bd82a85fc629
>>>>>>> 3abcfe4cede430b0b2dc1e5e423bb33d0da8224f
