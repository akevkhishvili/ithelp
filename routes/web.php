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

/*Route::get('/', function () {
    return view('welcome');
});*/
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/caseBoard', 'IT\CaseBoardController@caseboard')->name('caseBoard');
    Route::post('/finishCase', 'IT\CaseBoardController@finishCase')->name('finishCase');
    Route::post('/acceptCase', 'IT\CaseBoardController@acceptCase')->name('acceptCase');
    Route::post('/forwardCase', 'IT\CaseBoardController@forwardCase')->name('forwardCase');

    Route::get('/itUser', 'IT\ItUsersController@itUser')->name('itUser');
    Route::post('/itUser/insert', 'IT\ItUsersController@itUserInsert')->name('itUserInsert');
    Route::post('/itUser/edit', 'IT\ItUsersController@itUserEdit')->name('itUserEdit');
    Route::post('/itUser/delete', 'IT\ItUsersController@itUserDelete')->name('itUserDelete');

    Route::get('/staffUser', 'IT\StaffUserController@staffUser')->name('staffUser');
    Route::post('/staffUser/create', 'IT\StaffUserController@staffUserCreate')->name('staffUserCreate');
    Route::post('/staffUser/edit', 'IT\StaffUserController@staffUserEdit')->name('staffUserEdit');
    Route::post('/staffUser/staffdelete', 'IT\StaffUserController@staffdelete')->name('staffdelete');

    Route::get('/caseNotification', 'IT\CaseBoardController@caseNotification')->name('caseNotification');
    Route::post('/caseNotificationRecord', 'IT\CaseBoardController@caseNotificationRecord')->name('caseNotificationRecord');
    Route::post('/getStaffMembersForChat', 'IT\ChatController@getStaffMembersForChat')->name('getStaffMembersForChat');
    Route::post('/postItResponse', 'IT\CaseBoardController@postItResponse')->name('postItResponse');
    Route::post('/getItResponse', 'IT\CaseBoardController@getItResponse')->name('getItResponse');
});

Route::post('/getItResponseForUser', 'IT\CaseBoardController@getItResponseForUser')->name('getItResponseForUser');

Route::get('/', 'IT\CasePageController@casepage')->name('casePage');
Route::post('/', 'IT\CasePageController@newcase')->name('newCase');
Route::post('/close', 'IT\CasePageController@closecase')->name('closeCase');
Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
Route::post('/postMessage', 'IT\ChatController@postMessage')->name('postMessage');
Route::post('/postMessageIt', 'IT\ChatController@postMessageIt')->name('postMessageIt');

Route::post('/getChatMessages', 'IT\ChatController@getChatMessages')->name('getChatMessages');
Route::post('/getMessagesCount', 'IT\ChatController@getMessagesCount')->name('getMessagesCount');
Route::post('/getMessagesCountUser', 'IT\ChatController@getMessagesCountUser')->name('getMessagesCountUser');






Route::get('/home', 'HomeController@index')->name('home');
