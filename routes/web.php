<?php
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {


//        $gateway = resolve(\Sadegh\Payment\Gateways\Gateway::class);
//
//        $payment = new \Sadegh\Payment\Models\Payment();
//        $gateway->request($payment);

//    \Spatie\Permission\Models\Permission::create(['name' => 'manage role_permissions']);
//    auth()->user()->givePermissionTo(\Sadegh\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN);
     return auth()->user()->assignRole('teacher');
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


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




