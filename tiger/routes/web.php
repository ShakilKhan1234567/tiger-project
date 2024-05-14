<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\frontendController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordresetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Tagcontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariationController;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;


Route::get('/', [frontendController::class,'welcome'])->name('index');
Route::get('/dashboard', [BaseController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/product/details/{slug}', [frontendController::class,'product_details'])->name('product.details');
Route::post('/getsize', [frontendController::class, 'getsize']);
Route::post('/getquantity', [frontendController::class, 'getquantity']);
Route::get('/shop', [frontendController::class, 'shop'])->name('shop');
Route::get('/tag/product/{id}', [frontendController::class, 'tag_product'])->name('tag.product');

// API from others
Route::get('api/category', [frontendController::class, 'api_category']);


// recent view
Route::get('recent/view', [frontendController::class, 'recent_view'])->name('recent.view');
Route::get('faqs', [frontendController::class, 'faqs'])->name('faqs');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// banner
Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
Route::post('/banner/store', [BannerController::class, 'banner_store'])->name('banner.store');
Route::get('/banner/delete/{id}', [BannerController::class, 'banner_delete'])->name('banner.delete');
Route::get('/banner/edit/{id}', [BannerController::class, 'banner_edit'])->name('banner.edit');
Route::post('/update/banne/{id}', [BannerController::class, 'update_banner'])->name('update.banner');

// Exciting Offer
Route::get('/offer1', [OfferController::class, 'offer1'])->name('offer1');
Route::post('/offer1/update/{id}', [OfferController::class, 'offer1_update'])->name('offer1.update');
Route::post('/offer2/update/{id}', [OfferController::class, 'offer2_update'])->name('offer2.update');

// subscribe
Route::post('/subscribe/store', [BaseController::class, 'subscribe_store'])->name('subscribe.store');
Route::get('/subscribe/list', [BaseController::class, 'subscribe_list'])->name('subscribe.list');
Route::get('/delete/subscribe/{id}', [BaseController::class, 'delete_subscribe'])->name('delete.subscribe');




// user
Route::get('/profile/update', [UserController::class,'profile_update'])->name('profile.update');
Route::post('/profile/update/info', [UserController::class,'profile_update_info'])->name('profile_update_info');
Route::post('/password/update/info', [UserController::class,'password_update'])->name('password_update');
Route::post('/photo/update/info', [UserController::class,'photo_update'])->name('photo_update');

// user list
Route::post('/user/add',[BaseController::class,'user_add'])->name('user.add');
Route::get('/user/list',[BaseController::class,'user_list'])->name('user.list');
Route::get('/delete/user/{user_id}', [BaseController::class,'delete_user'])->name('delete.user');

// category
Route::get('/category', [CategoryController::class,'category'])->name('category');
Route::post('/category/store', [CategoryController::class,'category_store'])->name('category.store');
Route::get('/delete/category/{category_id}', [CategoryController::class,'delete_category'])->name('delete.category');
Route::get('/trash/category', [CategoryController::class,'trash_category'])->name('trash.category');
Route::get('/restore/category/{restore}', [CategoryController::class,'restore_category'])->name('restore.category');
Route::get('/permanent/delete/category/{permanent_delete}', [CategoryController::class,'permanent_delete_category'])->name('permanent.delete.category');
Route::get('/edit/category/{id}', [CategoryController::class,'edit_category'])->name('edit.category');
Route::post('/update/category/{id}', [CategoryController::class,'update_category'])->name('update.category');
Route::post('/checked/delete', [CategoryController::class,'checked_delete'])->name('checked.delete');
Route::post('/restore/all', [CategoryController::class,'restore_all'])->name('restore.all');

// subcategory
Route::get('/subcategory', [SubcategoryController::class,'sub_category'])->name('sub.category');
Route::post('/subcategory',[SubcategoryController::class,'subcategory_store'])->name('subcategory.store');
Route::get('/edit/subcategory/{id}', [SubcategoryController::class, 'edit_subcategory'])->name('edit.subcategory');
Route::post('/update/subcategory/{id}', [SubcategoryController::class, 'update_subcategory'])->name('update.subcategory');
Route::get('/delete/subcategory/{id}', [SubcategoryController::class, 'delete_subcategory'])->name('delete.subcategory');

// product
Route::post('/getSubcategory',[ProductController::class,'getSubcategory']);
Route::post('/product/store',[ProductController::class,'product_store'])->name('product.store');
Route::get('/product/list',[ProductController::class,'product_list'])->name('product.list');
Route::get('/add/product',[ProductController::class,'add_product'])->name('add.product');
Route::post('/getstatus',[ProductController::class,'getstatus']);
Route::get('/list/delete/{id}',[ProductController::class,'list_delete'])->name('list.delete');
Route::get('/view/list/{id}',[ProductController::class,'view_list'])->name('view.list');
Route::post('/product/update/{id}',[ProductController::class,'product_update'])->name('product.update');


// tag
Route::get('/tag', [TagController::class, 'tag'])->name('tag');
Route::post('/tag/store', [TagController::class, 'tag_store'])->name('tag.store');
Route::get('/tag/delete/{id}', [TagController::class, 'tag_delete'])->name('tag.delete');


// brand
Route::get('/brand/store', [BrandController::class, 'brand_store'])->name('brand.store');
Route::post('/brand', [BrandController::class, 'brand'])->name('brand');
Route::get('/brand/delete/{id}', [BrandController::class, 'brand_delete'])->name('delete.brand');

// variation
Route::get('/variation', [VariationController::class, 'variation'])->name('variation');
Route::post('/variation/store', [VariationController::class, 'variation_store'])->name('variation.store');
Route::post('/size', [VariationController::class, 'size'])->name('size');
Route::get('/delete/variation/{id}', [VariationController::class, 'delete_variation'])->name('delete.variation');
Route::get('/delete/size/{id}', [VariationController::class, 'delete_size'])->name('delete.size');

// inventory
Route::get('/add/inventory/{id}', [InventoryController::class, 'add_inventory'])->name('add.inventory');
Route::post('/inventory/store/{id}', [InventoryController::class, 'inventory_store'])->name('inventory.store');
Route::get('/delete/inventory/{id}', [InventoryController::class, 'delete_inventory'])->name('delete.inventory');


// customer
Route::get('/customer/login', [CustomerAuthController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/register', [CustomerAuthController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'customer_store'])->name('customer.store');
Route::post('/customer/logged', [CustomerAuthController::class, 'customer_logged'])->name('customer.logged');
Route::get('/customer/profile', [CustomerProfileController::class, 'customer_profile'])->name('customer.profile');
Route::get('/customer/logout', [CustomerProfileController::class, 'customer_logout'])->name('customer.logout');
Route::post('/customer/profile/update', [CustomerProfileController::class, 'profile_update'])->name('profile.update');
Route::get('/customer/my/order', [CustomerProfileController::class, 'my_orders'])->name('my.orders');
Route::get('/download/invoice/{id}', [CustomerProfileController::class, 'download_invoice'])->name('download.invoice');
Route::get('/email/verify/confirm/{token}', [CustomerProfileController::class, 'email_verify_confirm'])->name('email.verify.confirm');
Route::get('/resend/email/verification', [CustomerProfileController::class, 'resend_email_verification'])->name('resend.email.verification');
Route::post('/resent/email/verification/confirm', [CustomerProfileController::class, 'resent_email_verification_confirm'])->name('resent.verification.email.confirm');

// for captcha
Route::get('/reload-captcha', [CustomerAuthController::class, 'reloadCaptcha']);

// cart
Route::post('/add/cart', [CartController::class, 'add_cart'])->name('add.cart');
Route::get('/cart/remove/{id}', [CartController::class, 'cart_remove'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart')->middleware('customer');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');

// coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/status/{id}', [CouponController::class, 'coupon_status'])->name('coupon.status');
Route::get('/delete/status/{id}', [CouponController::class, 'delete_status'])->name('delete.status');

// checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/getCity', [CheckoutController::class, 'getcity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

// order
Route::get('/order', [OrderController::class, 'order'])->name('orders');
Route::post('/status/{id}', [OrderController::class, 'status'])->name('status');
Route::get('/cancel/order/{id}', [OrderController::class, 'cancel_order'])->name('cancel.order');
Route::post('/cancel/order/req/{id}', [OrderController::class, 'cancel_order_req'])->name('cancel.order.req');
Route::get('/order/cancel/list', [OrderController::class, 'order_cancel_list'])->name('order.cancel.list');
Route::get('/order/cancel/details/{id}', [OrderController::class, 'order_cancel_details'])->name('order.cancel.details');
Route::get('/cancel.accept/{id}', [OrderController::class, 'cancel_accept'])->name('cancel.accept');


// SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('sslpay');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);



// stripe
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


// /review
Route::post('/review/store/{id}', [frontendController::class, 'review_store'])->name('review.store');

// role manage
Route::get('/role/manage', [RoleController::class, 'role_manage'])->name('role.manage');
Route::post('/permission/store', [RoleController::class, 'permission_store'])->name('permission.store');
Route::post('/role/store', [RoleController::class, 'role_store'])->name('role.store');
Route::get('/delete/role/{id}', [RoleController::class, 'delete_role'])->name('delete.role');
Route::get('/edit/role/{id}', [RoleController::class, 'edit_role'])->name('edit.role');
Route::post('/update/role/{id}', [RoleController::class, 'update_role'])->name('update.role');
Route::post('/assign/store', [RoleController::class, 'assign_store'])->name('assign.store');
Route::get('/remove/role/{id}', [RoleController::class, 'remove_role'])->name('remove.role');


// password reset
Route::get('/password/reset', [PasswordresetController::class, 'password_reset'])->name('password.reset');
Route::post('/password/reset/req', [PasswordresetController::class, 'pass_reset_req'])->name('pass.reset.req');
Route::get('/password/reset/form/{token}', [PasswordresetController::class, 'password_reset_form'])->name('password.reset.form');
Route::post('/password/reset/confirm/{token}', [PasswordresetController::class, 'password_reset_confirm'])->name('password.reset.confirm');


// Faq
Route::resource('faq', FaqController::class);

// log means users all activity
Route::get('/log/info',[LogController::class, 'log_info'])->name('log.info');
