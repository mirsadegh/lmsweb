<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Route::get('/verify-link/{user}', function () {
//    if (request()->hasValidSignature()){
//        return 'ok';
//    }
//    return 'Failed';
//})->name('verify-link');
//
//Route::get('/test', function () {
//    $url = URL::temporarySignedRoute('verify-link',now()->addMinute(5),['user' => 5]);
//    dd($url);
//});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




