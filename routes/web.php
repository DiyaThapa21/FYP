<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\KhaltiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\AdminUserController;



// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    session()->flash('success', 'Successfully cache cleared.');
    return back();
})->name('cache.clear');

// STORAGE LINKED ROUTE
Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');

Auth::routes(['register' => false]);

// Authentication Routes
Route::controller(FrontendController::class)->group(function () {
    Route::get('user/login', 'login')->name('login.form');
    Route::post('user/login', 'loginSubmit')->name('login.submit');
    Route::get('user/logout', 'logout')->name('user.logout');
    Route::get('user/register', 'register')->name('register.form');
    Route::post('user/register', 'registerSubmit')->name('register.submit');

    Route::get('password-reset', 'showResetForm')->name('password.fromreset');
    Route::get('/', 'home')->name('home');
    Route::get('/home', 'index');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
});

Route::get('/product-cat/{slug}', [FrontendController::class, 'productCat'])->name('product-cat');
Route::controller(LoginController::class)->group(function () {
    Route::get('login/{provider}/', 'redirect')->name('login.redirect');
    Route::get('login/{provider}/callback/', 'Callback')->name('login.callback');
});

Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {

    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');

    Route::get('/membership', [HomeController::class, 'membership'])->name('user-membership');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::put('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');

    Route::get('/user-order', [HomeController::class, 'orderIndex'])->name('user.order.index');


    Route::get('/order/show/{id}', [HomeController::class, 'ordershow'])->name('user.order.show');
    Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('user.order.delete');

    Route::get('/user-review', [HomeController::class, 'productReviewIndex'])->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}', [HomeController::class, 'productReviewDelete'])->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}', [HomeController::class, 'productReviewEdit'])->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}', [HomeController::class, 'productReviewUpdate'])->name('user.productreview.update');


    Route::get('user-post/comment', [HomeController::class, 'userComment'])->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}', [HomeController::class, 'userCommentDelete'])->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}', [HomeController::class, 'userCommentEdit'])->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}', [HomeController::class, 'userCommentUpdate'])->name('user.post-comment.update');
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
});
// Cart Routes
Route::middleware('auth')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('/add-to-cart/{slug}', 'addToCart')->name('add-to-cart');
        Route::post('/add-to-cart', 'singleAddToCart')->name('single-add-to-cart');
        Route::get('cart-delete/{id}', 'cartDelete')->name('cart-delete');
        Route::post('cart-update', 'cartUpdate')->name('cart.update');
        Route::get('/checkout', 'checkout')->name('checkout');
    });

    Route::controller(WishlistController::class)->group(function () {
        Route::get('/wishlist/{slug}', 'wishlist')->name('add-to-wishlist');
        Route::get('wishlist-delete/{id}', 'wishlistDelete')->name('wishlist-delete');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::post('cart/order', 'store')->name('cart.order');
        Route::get('order/pdf/{id}', 'pdf')->name('order.pdf');
        Route::get('/income', 'incomeChart')->name('product.order.income');
    });
    Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');

    Route::post('/khalti/verifyPayment', [KhaltiController::class, 'verifyPayment'])->name('verifyPayment');
    Route::post('/khalti/storePayment', [KhaltiController::class, 'storePayment'])->name('khalti.storePayment');
    Route::get('/payment/success', [KhaltiController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [KhaltiController::class, 'cancel'])->name('payment.cancel');
});
Route::post('/adminlogin', [AdminController::class, 'adminloginSubmit'])->name('admin.login');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');


    Route::resources([
        'users' => UsersController::class,
        'banner' => BannerController::class,
        'brand' => BrandController::class,
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'post-category' => PostCategoryController::class,
        'post-tag' => PostTagController::class,
        'post' => PostController::class,
        'message' => MessageController::class,
        'order' => OrderController::class,
        'shipping' => ShippingController::class,
        'coupon' => CouponController::class,
        'review' => ProductReviewController::class,
        'comment' => PostCommentController::class,
        'message' => MessageController::class,
    ]);

    Route::resource('assignpermissions', RolePermissionController::class);

    Route::post('/product/status/update', [ProductController::class, 'updateStatus'])->name('product.status.update');

    Route::resource('roles', RoleController::class);

    Route::resource('admins', AdminUserController::class);

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions/add', [PermissionController::class, 'store'])->name('permissions.store');

    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');
    Route::post('post/{slug}/comment', [PostCommentController::class, 'store'])->name('post-comment.store');

    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');

    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.updatepassword');
});

Route::get('product-detail/{slug}', [FrontendController::class, 'productDetail'])->name('product-detail');
Route::get('/product-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'productSubCat'])->name('product-sub-cat');

Route::get('/cart', function () {
    return view('frontend.pages.cart');
})->name('cart');

Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blog.search');
Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');
Route::post('/product/search', [FrontendController::class, 'productSearch'])->name('product.search');
Route::match(['get', 'post'], '/filter', [FrontendController::class, 'productFilter'])->name('shop.filter');
Route::get('/product-lists', [FrontendController::class, 'productLists'])->name('product-lists');
Route::get('/product-grids', [FrontendController::class, 'productGrids'])->name('product-grids');
