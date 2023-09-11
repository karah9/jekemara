<?php

use App\Http\Livewire\TypeInfrastructure\CreateTypeInfrastructure;
use App\Http\Livewire\TypeInfrastructure\ListTypeInfrastructure;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function (){
    return view('auth.register');
})->name('register');
Route::get('/first-launch', \App\Livewire\ConfigurationForm::class)->name('first_launch');
Route::middleware([
    'auth:sanctum',
    'first_launch',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::prefix('/user')->name('user.')->group(function (){
        Route::get('/create', \App\Http\Livewire\User\CreateUser::class)->name('create');
        //->can('create', \App\Models\User::class)
    });
    Route::prefix('/rapport')->name('rapport.')->group(function (){
        Route::get('/rapport', \App\Livewire\Rapport\Rapport::class)->name('rapport');
        Route::get('/technique', \App\Livewire\Rapport\RapportTechnique::class)->name('technique');
//        Route::get('/technique/{fermeIds}/{startDate}/{endDate}', [\App\Http\Controllers\RapportTechniqueFermeController::class, 'index'])->name('technique.ferme');
//        Route::post('/technique', [\App\Http\Controllers\RapportTechniqueController::class, 'submit'])->name('submit');
    });
});
