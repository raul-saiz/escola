<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthorController;
use \App\Http\Controllers\AlumneController;
use \App\Http\Controllers\HorariController;
use \App\Http\Controllers\MatriculaController;
use \App\Http\Controllers\BaixaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'post'],'/', function () {
   // Route::view('/','welcome')->name('welcome');
    //Route::get('/')->name('welcome');
    return view('welcome');
});



//Route::get('/alumnes',[AlumneController::class,'alumnes'])->name('alumnes');

Route::prefix('alumnes')->name('alumnes.')->group(function(){

    Route::middleware(['guest:web'])->group(function(){
        Route::get('/llistat',[AlumneController::class,'alumnes'])->name('llistat');
       // Route::view('/forgot-password','back.pages.auth.forgot')->name('forgot-password');
        //Route::get('/horario',[AuthorController::class,'horario'])->name('horario');

    });
    Route::middleware([])->group(function(){
        Route::get('/alumnes',[AlumneController::class,'index'])->name('index');
    });
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:web'])->group(function(){
        Route::get('/matricula',[MatriculaController::class,'matricula'])->name('matricula');
    });
    Route::middleware([])->group(function(){
        Route::get('/index',[MatriculaController::class,'index'])->name('index');
    });
});

Route::prefix('profe')->name('profe.')->group(function(){

    Route::middleware(['guest:web'])->group(function(){
        Route::view('/login','back.pages.auth.login')->name('login');
        Route::view('/forgot-password','back.pages.auth.forgot')->name('forgot-password');
        Route::get('/llistat',[AuthorController::class,'listado'])->name('llistat');
        Route::get('/baixes',[AuthorController::class,'baixa'])->name('baixes');
        Route::get('/matricula',[AuthorController::class,'listado'])->name('matricula');
        Route::get('/horari/{id}',[AuthorController::class,'horario'])->name('horario');
        Route::get('/baixes/{id}',[BaixaController::class,'insertform'])->name('baixanova');
        Route::get('/baixes/{id}/add',[BaixaController::class,'insertform'])->name('baixaform');
        Route::post('/horari/{id}/add',[HorariController::class,'insert'])->name('insert');
        Route::post('/baixes/{id}/add',[BaixaController::class,'insert'])->name('insertbaixa');
        Route::get('/guardies',[BaixaController::class,'guardies'])->name('guardies');
        Route::post('/guardies',[BaixaController::class,'salvaguardies'])->name('salvaguardies');
    });

    Route::middleware([])->group(function(){
        Route::get('/home',[AuthorController::class,'index'])->name('home');
    });
});
