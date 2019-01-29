<?php

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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
  Route::get('/', function () {
    return view('welcome');
  })->name('default');
  Route::get('/home', 'HomeController@index')->name('home');

  // Rotas acessiveis somente para o perfil Administrador
  Route::group(['middleware' => 'isAdmin'], function() {
    Route::resource('usuarios', 'UsuarioController');
    Route::match(['get','post'],'usuarios/jsonlista','UsuarioController@jsonLista')->name('usuarios.jsonlista');
    Route::post('usuarios/destroy-list','UsuarioController@destroyList')->name('usuarios.destroy-list');
    Route::get('usuario/destroy-img/{id}','UsuarioController@destroyImg')->name('usuario.destroyimg');

    Route::resource('perfis', 'PerfilController');
    Route::match(['get','post'],'perfis/jsonlista','PerfilController@jsonlista')->name('perfis.jsonlista');
    Route::post('perfis/destroy-list','PerfilController@destroyList')->name('perfis.destroy-list');

    Route::resource('permissoes', 'PermissaoController');
    Route::match(['get','post'],'permissoes/jsonlista','PermissaoController@jsonlista')->name('permissoes.jsonlista');
    Route::post('permissoes/destroy-list','PermissaoController@destroyList')->name('permissoes.destroy-list');
  });
  
});
