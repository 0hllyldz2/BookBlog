<?php


use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
*/
Route::get('site-aktif-degil', function(){
    return view('front.offline');
});

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function () {
    Route::get('giris', [AuthController::class, 'login'])->name('login');
    Route::post('giris', [AuthController::class, 'loginPost'])->name('login.post');
});
//
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    Route::get('panel', [Dashboard::class, 'index'])->name('dashboard');
    //Metin Route's
    Route::get('/metinler/silinenler', [ArticleController::class, 'trashed'])->name('trashed.article');
    Route::resource('metinler', ArticleController::class);
    Route::get('/switch', [ArticleController::class, 'switch'])->name('switch');
    Route::get('/deletearticle/{id}', [ArticleController::class, 'delete'])->name('delete.article');
    Route::get('/harddeletearticle/{id}', [ArticleController::class, 'hardDelete'])->name('hard.delete.article');
    Route::get('/recoverarticle/{id}', [ArticleController::class, 'recover'])->name('recover.article');
    //Category Route's
    Route::get('/kategoriler', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/kategoriler/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/kategoriler/update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('/kategoriler/delete', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('/kategori/switch', [CategoryController::class, 'switch'])->name('category.switch');
    Route::get('/kategori/getData', [CategoryController::class, 'getData'])->name('category.getdata');
    // Page Route's
    Route::get('/sayfa/silinenler', [PageController::class, 'trashed'])->name('page.trashed');
    Route::get('/sayfalar', [PageController::class, 'index'])->name('page.index');
    Route::get('/sayfalar/olustur', [PageController::class, 'create'])->name('page.create');
    Route::get('/sayfalar/guncelle/{id}', [PageController::class, 'edit'])->name('page.edit');
    Route::put('/sayfalar/guncelle/{id}', [PageController::class, 'update'])->name('page.update');
    Route::post('/sayfalar/olustur', [PageController::class, 'store'])->name('page.store');
    Route::get('/sayfa/switch', [PageController::class, 'switch'])->name('page.switch');
    Route::get('/sayfa/sil/{id}', [PageController::class, 'delete'])->name('page.delete');
    Route::get('/sayfa/harddelete/{id}', [PageController::class, 'harddelete'])->name('page.hard.delete');
    Route::get('/sayfa/recover/{id}', [PageController::class, 'recover'])->name('page.recover');
    Route::get('/sayfa/siralama', [PageController::class, 'orders'])->name('page.orders');
    // Config Route's
    Route::get('/ayarlar', [ConfigController::class, 'index'])->name('config.index');
    Route::post('/ayarlar/update', [ConfigController::class, 'update'])->name('config.update');

    //
    Route::get('cikis', [AuthController::class, 'logout'])->name('logout');
});




/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('/sayfa', [Homepage::class, 'index']);
Route::get('/iletisim', [Homepage::class, 'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class, 'contactpost'])->name('contact.post');
Route::get('/kategori/{category}', [Homepage::class, 'category'])->name('category');
Route::get('/{category}/{slug}', [Homepage::class, 'single'])->name('single');
Route::get('/{sayfa}', [Homepage::class, 'page'])->name('page');

