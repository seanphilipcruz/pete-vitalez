<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WebsiteController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\WebsiteContentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');

// Validations for incoming creation of customer profiles
Route::post('validate/form', [Controller::class, 'validate_checkout_form'])->name('validate.form');
Route::post('send/request', [WebsiteController::class, 'create_request'])->name('send.request');

// For getting the artworks' page in the main website
Route::get('products', [WebsiteController::class, 'artworks'])->name('website.artworks');
Route::get('products/{id}', [WebsiteController::class, 'get_artwork'])->name('website.artwork.show');
Route::post('create/order/{product_id}', [WebsiteController::class, 'create_order'])->name('website.create.order');

// For getting the blogs' page in the main website
Route::get('articles', [WebsiteController::class, 'blogs'])->name('website.blogs');
Route::get('articles/{id}', [WebsiteController::class, 'get_blog'])->name('website.blogs.show');

Route::get('about', [WebsiteController::class, 'get_content'])->name('website.content.about');

Route::post('send/message', [WebsiteController::class, 'send_message'])->name('website.send.message');

Route::get('verify/invoice/{invoice_id}', [WebsiteController::class, 'verify_invoice'])->name('website.verify.invoice');

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'artworks'], function() {
        Route::get('/', [ProductsController::class, 'index'])->name('artworks');
        Route::get('view/{id}', [ProductsController::class, 'show'])->name('artworks.show');
        Route::post('store', [ProductsController::class, 'store'])->name('artworks.store');
        Route::match(['put', 'patch'], 'update/{id}', [ProductsController::class, 'update'])->name('artworks.update');
        Route::delete('delete/{id}', [ProductsController::class, 'destroy'])->name('artworks.destroy');
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', [BlogsController::class, 'index'])->name('blogs');
        Route::get('view/{id}', [BlogsController::class, 'show'])->name('blogs.show');
        Route::post('store', [BlogsController::class, 'store'])->name('blogs.store');
        Route::match(['put', 'patch'], 'update/{id}', [BlogsController::class, 'update'])->name('blogs.update');
        Route::delete('delete/{id}', [BlogsController::class, 'destroy'])->name('blogs.destroy');
    });

    Route::group(['prefix' => 'orders'], function() {
        Route::get('/', [OrdersController::class, 'index'])->name('orders');
        Route::get('view/{id}', [OrdersController::class, 'show'])->name('orders.show');
        Route::post('store', [OrdersController::class, 'store'])->name('orders.store');
        Route::match(['put', 'patch'], 'update/{id}', [OrdersController::class, 'update'])->name('orders.update');
        Route::delete('delete/{id}', [OrdersController::class, 'destroy'])->name('orders.destroy');
    });

    Route::group(['prefix' => 'photos'], function () {
        Route::get('/', [PhotosController::class, 'index'])->name('photos');
        Route::get('view/{id}', [PhotosController::class, 'show'])->name('photos.show');
        Route::post('store', [PhotosController::class, 'store'])->name('photos.store');
        Route::match(['put', 'patch'], 'update/{id}', [PhotosController::class, 'update'])->name('photos.update');
        Route::delete('delete/{id}', [PhotosController::class, 'destroy'])->name('photos.destroy');
    });

    Route::group(['prefix' => 'receiver'], function() {
        Route::post('/', [ShippingController::class, 'show'])->name('receiver.show');
    });

    Route::post('upload/photo', [Controller::class, 'upload_image'])->name('upload.photo');

    Route::group(['prefix' => 'requests'], function() {
        Route::get('/', [RequestController::class, 'index'])->name('requests');
        Route::get('view/{id}', [RequestController::class, 'show'])->name('request.show');
        Route::match(['put', 'patch'], 'update/{id}', [RequestController::class, 'update'])->name('requests.update');
        Route::delete('delete/{id}', [RequestController::class, 'destroy'])->name('requests.destroy');
    });

    Route::group(['prefix' => 'website/info'], function() {
        // for managing the contact information
        Route::group(['prefix' => 'contact'], function() {
            Route::get('', [WebsiteContentController::class, 'retrieve_contact'])->name('contact.info');
            Route::post('store', [WebsiteContentController::class, 'store_contact'])->name('contact.info.store');
            Route::match(['put', 'patch'], 'update/{id}', [WebsiteContentController::class, 'update_contact'])->name('contact.info.update');
        });

        // for managing the events that has been attended by the owner
        Route::group(['prefix' => 'events'], function () {
            Route::get('/', [WebsiteContentController::class, 'retrieve_events'])->name('events.info');
            Route::get('/{id}', [WebsiteContentController::class, 'retrieve_event'])->name('event.info');
            Route::post('store', [WebsiteContentController::class, 'store_event'])->name('events.info.store');
            Route::match(['put', 'patch'], 'update/{id}', [WebsiteContentController::class, 'update_event'])->name('events.info.update');
            Route::delete('delete/{id}', [WebsiteContentController::class, 'delete_event'])->name('events.info.delete');
        });

        Route::group(['prefix' => 'socials'], function() {
            Route::get('/', [WebsiteContentController::class, 'retrieve_social_accounts'])->name('socials.info');
            Route::get('/{id}', [WebsiteContentController::class, 'retrieve_social_account'])->name('social.info');
            Route::post('store', [WebsiteContentController::class, 'store_social_accounts'])->name('socials.info.store');
            Route::match(['put', 'patch'], 'update/{id}', [WebsiteContentController::class, 'update_social_accounts'])->name('socials.info.update');
            Route::delete('delete/{id}', [WebsiteContentController::class, 'delete_social_accounts'])->name('socials.info.delete');
        });
    });

    Route::group(['prefix' => 'messages'], function() {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('view/{id}', [MessageController::class, 'show'])->name('messages.show');
    });

    Route::get('dashboard', [Controller::class, 'dashboard'])->name('dashboard');
});
