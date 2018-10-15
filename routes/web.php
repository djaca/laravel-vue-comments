<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/{pageId}', function($pageId){
    return view('page',['pageId' => $pageId]);
});
