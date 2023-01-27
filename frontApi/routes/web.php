<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserArticles;
use App\Http\Livewire\Admin\UserIndex;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('Authentication', 'IsAdmin')->get('/user', UserIndex::class)->name('users.index');

Route::middleware('Authentication')->get('/article', [UserArticles::class, 'article'])->name('users.article');

Route::get('/', function () {
    $response = Http::get('http://127.0.0.1:80/api/userArticle');
    $jsonData = $response->json();
    $url = 'http://localhost/';
    // dd($jsonData);
    return view('welcome', compact('jsonData', 'url'));
})->name('welcome');

Route::get('/ekle', function () {
    $response = Http::post('http://127.0.0.1:80/api/item', [
        'user_id' => 1,
        'title' => 'front title',
        'desc' => 'foront description',
        'quantity' => 1,
    ]);
    return redirect()->route('welcome');
});

Route::get('/guncelle', function () {
    $response = Http::put('http://127.0.0.1:80/api/item/3', [
        'name' => 'front güncelleme',
        'desc' => 'foront güncelleme',
        'quantity' => 25,
    ]);
    return redirect()->route('welcome');
});

Route::get('/sil', function () {
    $response = Http::delete('http://127.0.0.1:80/api/item/6');
    return redirect()->route('welcome');
});


Route::get('/me', function () {
    $response = Http::get('http://127.0.0.1:80/api/auth/me');
    dd($response);
    return redirect()->route('welcome');
});