<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/', function () {
    $brands = DB::table('brands')->get();
    $abouts = DB::table('home_abouts')->first();
    return view('home',compact('brands','abouts'));
});

Route::get('/home', function () {
    echo "This is Home Page";
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', [ContactController::class, 'index'])->name('con');

// Category Controller
Route::get('/category/all', [CategoryController::class, 'allCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'addCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
Route::post('/category/update/{id}', [CategoryController::class, 'update']);
Route::get('/softdelete/category/{id}', [CategoryController::class, 'softDelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restore']);
Route::get('/pdelete/category/{id}', [CategoryController::class, 'pDelete']);

// brand controller
Route::get('/brand/all', [BrandController::class, 'index'])->name('all.brand');
Route::post('/brand/store', [BrandController::class, 'store'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'edit']);
Route::post('/brand/update/{id}', [BrandController::class, 'update']);
Route::get('/brand/delete/{id}', [BrandController::class, 'delete']);

// Multi Image Route
Route::get('/multi/image', [BrandController::class, 'multiPic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'storeImages'])->name('store.image');

// Admin ALL Route
Route::get('/home/slider', [HomeController::class, 'homeSlider'])->name('home.slider');
Route::get('/add/slider', [HomeController::class, 'addSlider'])->name('add.slider');
Route::post('/store/slider', [HomeController::class, 'storeSlider'])->name('store.slider');

// Home About All Route
Route::get('/home/about', [AboutController::class, 'homeAbout'])->name('home.about');
Route::get('/add/about', [AboutController::class, 'addAbout'])->name('add.about');
Route::post('/store/about', [AboutController::class, 'storeAbout'])->name('store.about');
Route::get('/about/edit/{id}', [AboutController::class, 'editAbout']);
Route::post('/update/homeabout/{id}', [AboutController::class, 'updateAbout']);
Route::get('/about/delete/{id}', [AboutController::class, 'deleteAbout']);






















Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    // $users = DB::table('users')->get();
    return view('admin.index');
})->name('dashboard');

//logout
Route::get('/user/logout', [BrandController::class, 'logout'])->name('user.logout');
