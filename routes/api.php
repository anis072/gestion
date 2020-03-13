<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/home', 'API\HomeController@index')->name('home');
Route::post('/login','API\AuthenController@login');
Route::post('/userauth','API\AuthenController@userauth');

//User
Route::apiResource('client' ,'API\UserController@dashbord');
Route::get('membrep','API\UserController@Membreprojet');
Route::get('/chef', 'API\UserController@chef');
Route::post('/ajouterChefDeProjet','API\UserController@ajouterChefDeProjet');
Route::post('user-login' ,'API\UserController@login');
Route::apiResource('membre','API\UserController');
Route::post('updateuserconnecte','API\UserController@updateuserconnecté');
Route::get('/chef','API\UserController@chefprojet');

//UserProjet
Route::apiResource('/userprojet' ,'API\UserProjetController');
Route::get('/membreid','API\UserProjetController@show');
Route::get('/projetsuser','API\UserProjetController@projetuser');
Route::post('/chefdeprojet','API\UserProjetController@storeChef');
Route::get('/getProjectsUserConnecte', 'API\UserProjetController@getProjectsUserConnecte');
Route::post('/chefdeprojetparchef','API\UserProjetController@storeChefparchef');
//Client
Route::post('/api/clientpname','API\CLientController@updatename');
Route::get('nameprojet' ,'API\CLientController@nomdeprojet');
Route::apiResource('client' ,'API\CLientController');
Route::get('clientp','API\CLientController@clientprojet');
//Projet
Route::get('/getProjects', 'API\ProjetController@getProjects');
Route::apiResource('projet' ,'API\ProjetController');
Route::post('/role' ,'API\ProjetController@role');
Route::get('/role','API\ProjetController@getrole');
Route::put('/projetup/{id}','API\ProjetController@updateparchef');




//Commentaire
Route::post('/comments/{key}', 'API\CommentController@store');
Route::get('/comments', 'API\CommentController@show');
Route::post('/commentsreponse/{key}', 'API\CommentController@storereply');
Route::get('/commentreply', 'API\CommentController@showreply');
