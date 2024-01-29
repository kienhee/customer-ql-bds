<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DropzoneController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Models\District;
use App\Models\Group;
use App\Models\Post;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
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
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::prefix('users')->name('users.')->middleware('can:users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->can('view', User::class);
        Route::get('/list', [UserController::class, 'list'])->name('list')->can('view', User::class);
        Route::get('/add', [UserController::class, 'add'])->name('add')->can('create', User::class);
        Route::post('/store', [UserController::class, 'store'])->name('store')->can('create', User::class);
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit')->can('update', User::class);
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update')->can('update', User::class);
        Route::post('/soft-delete/{id}', [UserController::class, 'softDelete'])->name('soft-delete')->can('delete', User::class);
        Route::post('/restore/{id}', [UserController::class, 'restore'])->name('restore')->can('delete', User::class);
        Route::post('/force-delete/{id}', [UserController::class, 'forceDelete'])->name('force-delete')->can('delete', User::class);
    });
    Route::prefix('posts')->name('posts.')->middleware('can:posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index')->can('view', Post::class);
        Route::get('/list', [PostController::class, 'list'])->name('list')->can('view', Post::class);
        Route::get('/add', [PostController::class, 'add'])->name('add')->can('create', Post::class);
        Route::post('/store', [PostController::class, 'store'])->name('store')->can('create', Post::class);
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit')->can('update', Post::class);
        Route::put('/update/{id}', [PostController::class, 'update'])->name('update')->can('update', Post::class);
        Route::post('/soft-delete/{id}', [PostController::class, 'softDelete'])->name('soft-delete')->can('delete', Post::class);
        Route::post('/restore/{id}', [PostController::class, 'restore'])->name('restore')->can('delete', Post::class);
        Route::post('/force-delete/{id}', [PostController::class, 'forceDelete'])->name('force-delete')->can('delete', Post::class);
    });
    Route::prefix('regions')->name('regions.')->middleware('can:regions')->group(function () {
        Route::get('/', [RegionController::class, 'index'])->name('index')->can('view', Region::class);
        Route::get('/list', [RegionController::class, 'list'])->name('list')->can('view', Region::class);
        Route::get('/add', [RegionController::class, 'add'])->name('add')->can('create', Region::class);
        Route::post('/store', [RegionController::class, 'store'])->name('store')->can('create', Region::class);
        Route::get('/edit/{id}', [RegionController::class, 'edit'])->name('edit')->can('update', Region::class);
        Route::put('/update/{id}', [RegionController::class, 'update'])->name('update')->can('update', Region::class);
        Route::post('/soft-delete/{id}', [RegionController::class, 'softDelete'])->name('soft-delete')->can('delete', Region::class);
        Route::post('/restore/{id}', [RegionController::class, 'restore'])->name('restore')->can('delete', Region::class);
        Route::post('/force-delete/{id}', [RegionController::class, 'forceDelete'])->name('force-delete')->can('delete', Region::class);
    });
    Route::prefix('provinces')->name('provinces.')->middleware('can:provinces')->group(function () {
        Route::get('/', [ProvinceController::class, 'index'])->name('index')->can('view', Province::class);
        Route::get('/list', [ProvinceController::class, 'list'])->name('list')->can('view', Province::class);
        Route::get('/add', [ProvinceController::class, 'add'])->name('add')->can('create', Province::class);
        Route::post('/store', [ProvinceController::class, 'store'])->name('store')->can('create', Province::class);
        Route::get('/edit/{id}', [ProvinceController::class, 'edit'])->name('edit')->can('update', Province::class);
        Route::put('/update/{id}', [ProvinceController::class, 'update'])->name('update')->can('update', Province::class);
        Route::post('/soft-delete/{id}', [ProvinceController::class, 'softDelete'])->name('soft-delete')->can('delete', Province::class);
        Route::post('/restore/{id}', [ProvinceController::class, 'restore'])->name('restore')->can('delete', Province::class);
        Route::post('/force-delete/{id}', [ProvinceController::class, 'forceDelete'])->name('force-delete')->can('delete', Province::class);
    });
    Route::prefix('districts')->name('districts.')->middleware('can:districts')->group(function () {
        Route::get('/', [DistrictController::class, 'index'])->name('index')->can('view', District::class);
        Route::get('/list', [DistrictController::class, 'list'])->name('list')->can('view', District::class);
        Route::get('/add', [DistrictController::class, 'add'])->name('add')->can('create', District::class);
        Route::post('/store', [DistrictController::class, 'store'])->name('store')->can('create', District::class);
        Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('edit')->can('update', District::class);
        Route::put('/update/{id}', [DistrictController::class, 'update'])->name('update')->can('update', District::class);
        Route::post('/soft-delete/{id}', [DistrictController::class, 'softDelete'])->name('soft-delete')->can('delete', District::class);
        Route::post('/restore/{id}', [DistrictController::class, 'restore'])->name('restore')->can('delete', District::class);
        Route::post('/force-delete/{id}', [DistrictController::class, 'forceDelete'])->name('force-delete')->can('delete', District::class);
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::put('/change-password/{email}', [ProfileController::class, 'handleChangePassword'])->name('handle-change-password');
        Route::get('/login-history', [ProfileController::class, 'loginHistory'])->name('login-history');
    });
    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->can('view', Group::class);
        Route::get('/add-role', [PermissionController::class, 'addRole'])->name('add-role')->can('create', Group::class);
        Route::post('/store-role', [PermissionController::class, 'storeRole'])->name('store-role')->can('create', Group::class);
        Route::get('/edit-role/{group}', [PermissionController::class, 'editRole'])->name('edit-role')->can('update', Group::class);
        Route::put('/update-role/{id}', [PermissionController::class, 'updateRole'])->name('update-role')->can('update', Group::class);
        Route::delete('/delete-role/{id}', [PermissionController::class, 'deleteRole'])->name('delete-role')->can('delete', Group::class);

        Route::get('/list-permission', [PermissionController::class, 'listPermission'])->name('list-permission');
        Route::post('/add-permission', [PermissionController::class, 'addPermission'])->name('add-permission');
        Route::get('/edit-permission/{module}', [PermissionController::class, 'editPermission'])->name('edit-permission');
        Route::put('/update-permission/{id}', [PermissionController::class, 'updatePermission'])->name('update-permission');
        Route::post('/delete-permission/{id}', [PermissionController::class, 'deletePermission'])->name('delete-permission');
    });
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });
    Route::get('/library', function () {
        return view('admin.library.index');
    })->middleware('can:library')->name('library');
});
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'handleLogin'])->name('handleLogin');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AuthController::class, 'ForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'SendMailForgotPassword'])->name('SendMailForgotPassword');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/reset-password', [AuthController::class, 'PostResetPassword'])->name('PostResetPassword');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
