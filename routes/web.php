<?php

use App\Http\Controllers\HomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('posts', function (Request $request) {
    $newPost = Post::create($request->all());
});

Route::post('posts', function (Request $request) {
    $newPost = Post::create($request->only([
        'title',
        'body',
    ]));
});

Route::get('create-or-update', [HomeController::class, 'index']);
Route::get('was-changed', [HomeController::class, 'changed']);
Route::get('model-observers', [HomeController::class, 'modelObserverExamples']);

