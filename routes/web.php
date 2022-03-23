<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return inertia('Home');
});

Route::post('quizzes', [QuizController::class, 'store'])->name('quizzes.store');
Route::get('quizzes/{quiz:uuid}', [QuizController::class, 'show'])->name('quizzes.show');
Route::post('quizzes/{quiz:uuid}', [QuizController::class, 'submit'])->name('quizzes.submit');

Route::get('leaders', [QuizController::class, 'leaders'])->name('leaders.index');
