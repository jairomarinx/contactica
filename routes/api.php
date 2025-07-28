<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('create',[UsuariosController::class, "create"])->name("create");
Route::post('edit/{id}',[UsuariosController::class, "edit"])->name("edit");
Route::get('show/{id}',[UsuariosController::class, "show"])->name("show");
Route::get('list',[UsuariosController::class, "list"])->name("edit");
Route::delete('delete/{id}',[UsuariosController::class, "delete"])->name("delete");





