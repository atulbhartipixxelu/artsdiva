<?php

use App\Http\Controllers\Account\AuthController as AccountAuthController;
use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
use App\Http\Controllers\Account\OrderController as AccountOrderController;
use App\Http\Controllers\Account\WishlistController as AccountWishlistController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\ArtworkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ExhibitionController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\InquiryAdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PublicationController;
use App\Http\Controllers\Admin\StatusToggleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\PublicContentController;
use App\Http\Controllers\StorageFileController;
use Illuminate\Support\Facades\Route;

// Hostinger-safe media: works even when public/storage symlink is missing/broken.
Route::get('/storage/{path}', StorageFileController::class)
    ->where('path', '.*')
    ->name('storage.serve');

Route::get('/', HomeController::class)->name('home');

Route::get('/catalogue', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/catalogue/suggest', [CatalogueController::class, 'suggest'])->name('catalogue.suggest');
Route::get('/catalogue/{slug}', [CatalogueController::class, 'show'])->name('catalogue.show');

Route::get('/leasing-inquiry', [InquiryController::class, 'create'])->name('inquiry.create');
Route::post('/leasing-inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::get('/leasing-inquiry/confirmation', [InquiryController::class, 'confirmation'])->name('inquiry.confirmation');

Route::post('/currency', CurrencyController::class)->name('currency.set');

Route::get('/leasing', [PageViewController::class, 'show'])->defaults('slug', 'leasing')->name('leasing');
Route::get('/about', [PageViewController::class, 'show'])->defaults('slug', 'about')->name('about');
Route::get('/services', [PageViewController::class, 'show'])->defaults('slug', 'leasing')->name('services');
Route::get('/contact', [PageViewController::class, 'show'])->defaults('slug', 'contact')->name('contact');

Route::get('/artists', [PublicContentController::class, 'artists'])->name('artists');
Route::get('/artists/{slug}', [PublicContentController::class, 'artistShow'])->name('artists.show');
Route::get('/news', [PublicContentController::class, 'news'])->name('news');
Route::get('/news/{slug}', [PublicContentController::class, 'newsShow'])->name('news.show');
Route::get('/events', [PublicContentController::class, 'events'])->name('events');
Route::get('/exhibitions', [PublicContentController::class, 'exhibitions'])->name('exhibitions');
Route::get('/publications', [PublicContentController::class, 'publications'])->name('publications');
Route::get('/publications/{slug}', [PublicContentController::class, 'publicationShow'])->name('publications.show');

/* Customer account */
Route::middleware('guest')->prefix('account')->name('account.')->group(function () {
    Route::get('/login', [AccountAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AccountAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AccountAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AccountAuthController::class, 'register'])->name('register.store');
});

Route::middleware(['auth', 'customer'])->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountDashboardController::class, 'index'])->name('dashboard');
    Route::get('/purchases', [AccountDashboardController::class, 'purchases'])->name('purchases');
    Route::get('/wishlist', [AccountDashboardController::class, 'wishlist'])->name('wishlist');
    Route::get('/profile', [AccountDashboardController::class, 'editProfile'])->name('profile');
    Route::put('/profile', [AccountDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/wishlist/{artwork}', [AccountWishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{artwork}', [AccountWishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/orders', [AccountOrderController::class, 'store'])->name('orders.store');
    Route::post('/logout', [AccountAuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'show'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/admin/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('hero', HeroSlideController::class)->except(['show']);
    Route::resource('artworks', ArtworkController::class)->except(['show']);
    Route::resource('artists', ArtistController::class)->except(['show']);
    Route::resource('exhibitions', ExhibitionController::class)->except(['show']);
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('news', NewsController::class)->except(['show'])->parameters(['news' => 'news']);
    Route::resource('publications', PublicationController::class)->except(['show']);
    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');

    Route::patch('{type}/{id}/toggle-status', StatusToggleController::class)
        ->whereIn('type', ['artworks', 'artwork-visibility', 'artists', 'hero', 'exhibitions', 'events', 'news', 'publications', 'pages', 'users'])
        ->whereNumber('id')
        ->name('toggle-status');

    Route::get('inquiries', [InquiryAdminController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [InquiryAdminController::class, 'show'])->name('inquiries.show');
    Route::delete('inquiries/{inquiry}', [InquiryAdminController::class, 'destroy'])->name('inquiries.destroy');

    Route::middleware('superadmin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
