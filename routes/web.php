<?php

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
    return view('bem_vindo');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');

Route::get('tarefa/export/{extensao}', 'App\Http\Controllers\TarefaController@export')->name('tarefa.export');

Route::resource('tarefa', 'App\Http\Controllers\TarefaController')->middleware('verified');

Route::post('tarefa/task', 'App\Http\Controllers\TarefaController@getTaskTable')->middleware('verified')->name('task_datatable');

Route::get('mensagem_teste', function () {
    return new \App\Mail\MensagemTesteMail();
});
