<?php

use App\Http\Controllers\ArfFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ReplacementController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuccessController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\WelcomeController;
use App\Models\Desktop;
use App\Models\Laptop;
use App\Models\Tablet;
use App\Services\ArfFormService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/arf-new', [ArfFormController::class, 'index']);
    Route::get('/arf-edit/{id}', [ArfFormController::class, 'edit']);
    Route::get('/search', [SearchController::class, 'index'])->name('arfform.search');
    Route::post('/arf-form', [App\Http\Controllers\ArfFormController::class, 'create'])->name('arfform.submit');
    Route::post('/arf-form/update', [App\Http\Controllers\ArfFormController::class, 'update'])->name('arfform.update');
    Route::get('/arf-offboarding/{id}', [ArfFormController::class, 'destroy']);
    Route::post('/arf-offboarding/{id}', [ArfFormController::class, 'startOffboarding'])->name('arfform.destroy');
    Route::get('/search-asset-availability', [SearchController::class, 'searchAsset']);
    Route::get('/get-brands', [SearchController::class, 'getBrands']);
    Route::get('/welcome', [WelcomeController::class, 'index']);

    Route::get('/upload-assets', [UploadController::class, 'index']);
    Route::post('/upload-assets', [UploadController::class, 'create'])->name('arfform.upload');
    Route::get('/import/{asset}', [ImportController::class, 'import']);
    Route::post('/asset-import', [ImportController::class, 'assetImport'])->name('asset.import');
    Route::get('/refresh-assets', [ImportController::class, 'refreshAssets'])->name('import.refresh');
    Route::get('/get-ad-employee/{empId}', [SearchController::class, 'getADEmployee'])->name('search.aduser');
    Route::post('/free-asset', [ArfFormController::class, 'freeAsset']);
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'password.request' => false
]);

Route::get('/verify/{token}', [SuccessController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});